<?php

namespace App\Http\Controllers\Management;

use App\Http\Controllers\Controller;
use App\Models\CustomUser;
use App\Models\Feature;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Illuminate\Http\RedirectResponse;

class UserFeatureAccessController extends Controller
{
    /**
     * Display users with their features assignment
     */
    public function index(Request $request): View
    {
        if (!auth('custom')->user() || !auth('custom')->user()->hasFeature('management_access')) {
            abort(403, 'Akses ditolak: Anda tidak memiliki fitur Access Management.');
        }

        $query = CustomUser::with('features');

        // Search functionality
        if ($request->filled('search')) {
            $search = $request->input('search');
            $query->where(function ($q) use ($search) {
                $q->where('username', 'like', "%{$search}%")
                  ->orWhere('nik', 'like', "%{$search}%");
            });
        }

        $users = $query->paginate(5);
        return view('management.access.index', compact('users'));
    }


    /**
     * Show form to assign features to a specific user
     */
    public function edit($id): View
    {
        if (!auth('custom')->user() || !auth('custom')->user()->hasFeature('management_access')) {
            abort(403, 'Akses ditolak: Anda tidak memiliki fitur Access Management.');
        }
        $user = CustomUser::findOrFail($id);

        // Ambil fitur utama (parent_id IS NULL) beserta anak-anaknya (children)
        $topFeatures = Feature::with('children')->whereNull('parent_id')->orderBy('sort_order')->get();
        $userFeatures = $user->features->pluck('id')->toArray();

        $groupedFeatures = [];
        $standaloneFeatures = [];

        foreach ($topFeatures as $feature) {
            if ($feature->children->isNotEmpty()) {
                $groupedFeatures[$feature->slug] = [
                    'parent' => $feature,
                    'children' => $feature->children
                ];
            } else {
                $standaloneFeatures[] = $feature;
            }
        }

        return view('management.access.edit', compact(
            'user', 
            'groupedFeatures', 
            'standaloneFeatures', 
            'userFeatures'
        ));
    }

    /**
     * Update features for a user
     */
    public function update(Request $request, $id): RedirectResponse
    {
        if (!auth('custom')->user() || !auth('custom')->user()->hasFeature('management_access')) {
            abort(403, 'Akses ditolak: Anda tidak memiliki fitur Access Management.');
        }
        $user = CustomUser::findOrFail($id);

        $validated = $request->validate([
            'features' => 'array',
            'features.*' => 'exists:features,id',
        ]);

        $features = $validated['features'] ?? [];

        // Sync features (remove old, add new)
        $user->features()->sync($features);

        return redirect()->route('management.access.index')
            ->with('success', 'Hak akses user berhasil diupdate');
    }

    /**
     * Bulk update features for multiple users
     */
    public function bulkUpdate(Request $request): RedirectResponse
    {
        if (!auth('custom')->user() || !auth('custom')->user()->hasFeature('management_access')) {
            abort(403, 'Akses ditolak: Anda tidak memiliki fitur Access Management.');
        }

        $validated = $request->validate([
            'user_ids' => 'required|array',
            'user_ids.*' => 'exists:users,id',
            'features' => 'array',
            'features.*' => 'exists:features,id',
            'action' => 'required|in:assign,remove,replace',
        ]);

        $features = $validated['features'] ?? [];
        $users = CustomUser::whereIn('id', $validated['user_ids'])->get();

        foreach ($users as $user) {
            if ($validated['action'] === 'assign') {
                $user->features()->attach($features);
            } elseif ($validated['action'] === 'remove') {
                $user->features()->detach($features);
            } elseif ($validated['action'] === 'replace') {
                $user->features()->sync($features);
            }
        }

        return redirect()->route('management.access.index')
            ->with('success', 'Hak akses berhasil diupdate untuk ' . count($users) . ' user');
    }

    /**
     * Quick toggle feature for a user (AJAX)
     */
    public function toggleFeature(Request $request, $id, Feature $feature)
    {
        if (!auth('custom')->user() || !auth('custom')->user()->hasFeature('management_access')) {
            abort(403, 'Akses ditolak: Anda tidak memiliki fitur Access Management.');
        }
        $user = CustomUser::findOrFail($id);

        if ($user->features()->where('feature_id', $feature->id)->exists()) {
            $user->features()->detach($feature->id);
            return response()->json(['status' => 'removed', 'message' => 'Feature dihapus']);
        } else {
            $user->features()->attach($feature->id);
            return response()->json(['status' => 'added', 'message' => 'Feature ditambahkan']);
        }
    }

    /**
     * Export user access matrix to Excel
     */
    public function export(Request $request)
    {
        if (!auth('custom')->user() || !auth('custom')->user()->hasFeature('management_access')) {
            abort(403, 'Akses ditolak: Anda tidak memiliki fitur Access Management.');
        }

        // Fetch users matching search filter (to be represented as columns)
        $query = CustomUser::with('features');

        if ($request->filled('search')) {
            $search = $request->input('search');
            $query->where(function ($q) use ($search) {
                $q->where('username', 'like', "%{$search}%")
                  ->orWhere('nik', 'like', "%{$search}%");
            });
        }

        $users = $query->get();

        // Fetch all features in tree hierarchy order (to be represented as rows)
        $allFeatures = Feature::with('parent')->orderBy('sort_order')->get();
        $featuresByParent = $allFeatures->groupBy('parent_id');
        $roots = $featuresByParent->get(null) ?? collect();

        $flatFeatures = collect();
        foreach ($roots as $root) {
            $flatFeatures->push($root);
            $children = $featuresByParent->get($root->id) ?? collect();
            foreach ($children as $child) {
                $flatFeatures->push($child);
            }
        }

        // Handle orphans if any exist (safety fallback)
        $addedIds = $flatFeatures->pluck('id')->toArray();
        $orphans = $allFeatures->whereNotIn('id', $addedIds);
        foreach ($orphans as $orphan) {
            $flatFeatures->push($orphan);
        }

        $spreadsheet = new \PhpOffice\PhpSpreadsheet\Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();
        $sheet->setTitle('User Access Matrix');

        // Set Header Row (No., Nama Fitur, Slug, then each user username)
        $headers = ['No.', 'Nama Fitur', 'Slug'];
        $columnIndex = 1;

        foreach ($headers as $header) {
            $sheet->setCellValueExplicit([$columnIndex, 1], $header, \PhpOffice\PhpSpreadsheet\Cell\DataType::TYPE_STRING);
            $columnIndex++;
        }

        foreach ($users as $user) {
            $userLabel = $user->username;
            if (!empty($user->role)) {
                $roleDisplay = $user->role;
                if ($user->role === 'admin') $roleDisplay = 'ADMIN';
                elseif ($user->role === 'superadmin') $roleDisplay = 'SUPERADMIN';
                elseif ($user->role === 'viewer_ho' || $user->role === 'viewer_unit') $roleDisplay = 'VIEWER';
                else $roleDisplay = strtoupper($roleDisplay);
                $userLabel .= ' (' . $roleDisplay . ')';
            }
            $sheet->setCellValueExplicit([$columnIndex, 1], $userLabel, \PhpOffice\PhpSpreadsheet\Cell\DataType::TYPE_STRING);
            $columnIndex++;
        }

        // Header Styling
        $maxColLetter = \PhpOffice\PhpSpreadsheet\Cell\Coordinate::stringFromColumnIndex($columnIndex - 1);
        $headerStyle = [
            'font' => [
                'bold' => true,
                'color' => ['argb' => 'FFFFFFFF'],
            ],
            'fill' => [
                'fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID,
                'startColor' => ['argb' => 'FF16A34A'], // Green background
            ],
            'alignment' => [
                'horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER,
                'vertical' => \PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER,
            ],
            'borders' => [
                'allBorders' => [
                    'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
                ],
            ],
        ];
        $sheet->getStyle('A1:' . $maxColLetter . '1')->applyFromArray($headerStyle);
        $sheet->getRowDimension(1)->setRowHeight(25);

        // Populate Rows (Features)
        $row = 2;
        foreach ($flatFeatures as $index => $feature) {
            $col = 1;
            // No.
            $sheet->setCellValue([$col++, $row], $index + 1);

            // Nama Fitur (indented if it is a child)
            $isChild = !empty($feature->parent_id);
            $displayName = $isChild ? '    └─ ' . $feature->name : $feature->name;
            $sheet->setCellValue([$col++, $row], $displayName);

            // Slug
            $sheet->setCellValue([$col++, $row], $feature->slug);

            // Access Indicators for each user
            foreach ($users as $user) {
                $hasAccess = $user->features->contains('id', $feature->id);
                $value = $hasAccess ? 'V' : '-';
                $sheet->setCellValue([$col, $row], $value);

                // Center align matrix cells
                $sheet->getStyle([$col, $row])->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);

                if ($hasAccess) {
                    $sheet->getStyle([$col, $row])->getFont()->getColor()->setARGB('FF16A34A'); // Green text
                    $sheet->getStyle([$col, $row])->getFont()->setBold(true);
                } else {
                    $sheet->getStyle([$col, $row])->getFont()->getColor()->setARGB('FF9CA3AF'); // Gray text
                }
                $col++;
            }

            // Apply borders to the row
            $sheet->getStyle('A' . $row . ':' . $maxColLetter . $row)->applyFromArray([
                'borders' => [
                    'allBorders' => [
                        'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
                    ],
                ],
                'alignment' => [
                    'vertical' => \PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER,
                ],
            ]);

            $sheet->getStyle('A' . $row)->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);

            $row++;
        }

        // Auto size columns
        for ($i = 1; $i < $columnIndex; $i++) {
            $sheet->getColumnDimensionByColumn($i)->setAutoSize(true);
        }

        $writer = new \PhpOffice\PhpSpreadsheet\Writer\Xlsx($spreadsheet);
        $fileName = 'Export_User_Access_Matrix_' . date('Y-m-d_His') . '.xlsx';

        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment; filename="'. urlencode($fileName).'"');
        header('Cache-Control: max-age=0');

        $writer->save('php://output');
        exit;
    }
}
