<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

class ExportController extends Controller
{
    public function exportToExcel(User $user)
    {
        $this->authorize('admin');
        // Ambil data user berdasarkan parameter $user
        $userData = $user->toArray();

        // Ambil data absensi user
        $attendances = $user->attendance;

        // Inisialisasi objek Spreadsheet
        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();

        // Set judul kolom
        $sheet->setCellValue('A1', 'Nama');
        $sheet->setCellValue('B1', 'Hadir');
        $sheet->setCellValue('C1', 'Sakit');
        $sheet->setCellValue('D1', 'Ijin');
        $sheet->setCellValue('E1', 'Alpha');
        $sheet->setCellValue('F1', 'Jam Masuk');
        $sheet->setCellValue('G1', 'Jam Pulang');
        $sheet->setCellValue('H1', 'Lokasi');

        // Set nilai data
        $row = 2;
        foreach ($attendances as $attendance) {
            $sheet->setCellValue('A' . $row, $userData['name']);
            $sheet->setCellValue('B' . $row, $attendance['present']);
            $sheet->setCellValue('C' . $row, $attendance['sick']);
            $sheet->setCellValue('D' . $row, $attendance['permission']);
            $sheet->setCellValue('E' . $row, $attendance['notAbsent']);
            $sheet->setCellValue('F' . $row, $attendance['check_in']);
            $sheet->setCellValue('G' . $row, $attendance['check_out']);
            $sheet->setCellValue('H' . $row, $attendance['location']);
            $row++;
        }

        // hitung jumlah masuk,ijin sakit dll
        $sheet->setCellValue('A'.$row, 'total');
        $sheet->setCellValue('B'.$row, $attendances->sum('present'));
        $sheet->setCellValue('C'.$row, $attendances->sum('sick'));
        $sheet->setCellValue('D'.$row, $attendances->sum('permission'));
        $sheet->setCellValue('E'.$row, $attendances->sum('notAbsent'));

        // Buat objek Writer untuk menulis ke file XLSX


        // Generate nama file yang unik
        $filename = 'export_' . time() . '.xlsx';
        $path = storage_path('app/public/exports/' . $filename);

        // Simpan file XLSX
        $writer = new Xlsx($spreadsheet);
        $writer->save($path);

        // Mengembalikan file XLSX sebagai respons download
        return response()->download($path)->deleteFileAfterSend(true);
    }
}
