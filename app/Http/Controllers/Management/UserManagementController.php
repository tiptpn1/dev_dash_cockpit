<?php

namespace App\Http\Controllers\Management;

use App\Http\Controllers\Controller;
use App\Models\CustomUser;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Illuminate\Http\RedirectResponse;

class UserManagementController extends Controller
{
    /**
     * Display a listing of users
     */
    public function index(Request $request): View
    {
        if (!auth('custom')->user() || !auth('custom')->user()->hasFeature('management_users')) {
            abort(403, 'Akses ditolak: Anda tidak memiliki fitur User Management.');
        }

        $query = CustomUser::query();

        // Search functionality
        if ($request->filled('search')) {
            $search = $request->input('search');
            $query->where(function ($q) use ($search) {
                $q->where('username', 'like', "%{$search}%")
                  ->orWhere('nik', 'like', "%{$search}%");

            });
        }

        $users = $query->paginate(5);
        return view('management.users.index', compact('users'));
    }

    /**
     * Export users to Excel
     */
    public function export(Request $request)
    {
        if (!auth('custom')->user() || !auth('custom')->user()->hasFeature('management_users')) {
            abort(403, 'Akses ditolak: Anda tidak memiliki fitur User Management.');
        }

        $query = CustomUser::query();

        // Search functionality
        if ($request->filled('search')) {
            $search = $request->input('search');
            $query->where(function ($q) use ($search) {
                $q->where('username', 'like', "%{$search}%")
                  ->orWhere('nik', 'like', "%{$search}%");
            });
        }

        $users = $query->get();

        $spreadsheet = new \PhpOffice\PhpSpreadsheet\Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();
        $sheet->setTitle('Data User');

        // Set header
        $headers = ['No.', 'Username', 'NIK', 'Plant', 'Role'];
        $columnLetter = 'A';
        foreach ($headers as $header) {
            $sheet->setCellValue($columnLetter . '1', $header);
            $columnLetter++;
        }

        // Styling for header
        $headerStyleArray = [
            'font' => [
                'bold' => true,
                'color' => ['argb' => 'FFFFFFFF'],
                'size' => 12,
            ],
            'fill' => [
                'fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID,
                'startColor' => ['argb' => 'FF16A34A'], // Green-600
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
        $sheet->getStyle('A1:E1')->applyFromArray($headerStyleArray);
        $sheet->getRowDimension(1)->setRowHeight(25);

        // Populate data
        $row = 2;
        foreach ($users as $index => $user) {
            $sheet->setCellValue('A' . $row, $index + 1);
            $sheet->setCellValue('B' . $row, $user->username);
            $sheet->setCellValue('C' . $row, $user->nik ?? '-');
            $sheet->setCellValue('D' . $row, $user->plant ?? '-');
            
            $roleDisplay = $user->role ?? '-';
            if ($user->role === 'admin') $roleDisplay = 'ADMIN';
            elseif ($user->role === 'superadmin') $roleDisplay = 'SUPERADMIN';
            elseif ($user->role === 'viewer_ho' || $user->role === 'viewer_unit') $roleDisplay = 'VIEWER';
            else $roleDisplay = strtoupper($roleDisplay);
            
            $sheet->setCellValue('E' . $row, $roleDisplay);

            $sheet->getStyle('A' . $row . ':E' . $row)->applyFromArray([
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
        foreach (range('A', 'E') as $col) {
            $sheet->getColumnDimension($col)->setAutoSize(true);
        }

        $writer = new \PhpOffice\PhpSpreadsheet\Writer\Xlsx($spreadsheet);
        $fileName = 'Export_Manajemen_User_' . date('Y-m-d_His') . '.xlsx';

        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment; filename="'. urlencode($fileName).'"');
        header('Cache-Control: max-age=0');

        $writer->save('php://output');
        exit;
    }

    /**
     * Show the form for creating a new user
     */
    public function create(): View
    {
        if (!auth('custom')->user() || !auth('custom')->user()->hasFeature('management_users')) {
            abort(403, 'Akses ditolak: Anda tidak memiliki fitur User Management.');
        }
        return view('management.users.create');
    }

    /**
     * Store a newly created user
     */
    public function store(Request $request): RedirectResponse
    {
        if (!auth('custom')->user() || !auth('custom')->user()->hasFeature('management_users')) {
            abort(403, 'Akses ditolak: Anda tidak memiliki fitur User Management.');
        }

        $validated = $request->validate([
            'username' => 'required|unique:users,username|min:3|max:50',
            'password' => 'required|min:6',
            'nik' => 'nullable|string|max:20',
            'role' => 'nullable|string|max:50',
            'plant' => 'nullable|string|max:50',
            'regional' => 'nullable|string|max:50',
        ]);

        $validated['password'] = bcrypt($validated['password']);

        CustomUser::create($validated);

        return redirect()->route('management.users.index')
            ->with('success', 'User berhasil ditambahkan');
    }

    /**
     * Show the form for editing a user
     */
    public function edit($id): View
    {
        if (!auth('custom')->user() || !auth('custom')->user()->hasFeature('management_users')) {
            abort(403, 'Akses ditolak: Anda tidak memiliki fitur User Management.');
        }
        $user = CustomUser::findOrFail($id);
        return view('management.users.edit', compact('user'));
    }

    /**
     * Update the specified user
     */
    public function update(Request $request, $id): RedirectResponse
    {
        if (!auth('custom')->user() || !auth('custom')->user()->hasFeature('management_users')) {
            abort(403, 'Akses ditolak: Anda tidak memiliki fitur User Management.');
        }
        $user = CustomUser::findOrFail($id);

        $validated = $request->validate([
            'username' => 'required|unique:users,username,' . $user->id . '|min:3|max:50',
            'password' => 'nullable|min:6',
            'nik' => 'nullable|string|max:20',
            'role' => 'nullable|string|max:50',
            'plant' => 'nullable|string|max:50',
            'regional' => 'nullable|string|max:50',
        ]);

        if ($request->filled('password')) {
            $validated['password'] = bcrypt($validated['password']);
        } else {
            unset($validated['password']);
        }

        $user->update($validated);

        return redirect()->route('management.users.index')
            ->with('success', 'User berhasil diupdate');
    }

    /**
     * Delete the specified user
     */
    public function destroy($id): RedirectResponse
    {
        if (!auth('custom')->user() || !auth('custom')->user()->hasFeature('management_users')) {
            abort(403, 'Akses ditolak: Anda tidak memiliki fitur User Management.');
        }
        $user = CustomUser::findOrFail($id);
        
        $user->delete();

        return redirect()->route('management.users.index')
            ->with('success', 'User berhasil dihapus');
    }
}
