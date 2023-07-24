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
        $sheet->setCellValue('D1', 'Hadir');
        $sheet->setCellValue('E1', 'Sakit');
        $sheet->setCellValue('F1', 'Ijin');
        $sheet->setCellValue('G1', 'Alpha');
        $sheet->setCellValue('H1', 'Masuk');
        $sheet->setCellValue('I1', 'Pulang');
        $sheet->setCellValue('J1', 'Lokasi');
        $sheet->mergeCells('A1:C1');

        // Set nilai data
        $row = 2;
        foreach ($attendances as $attendance) {
            $sheet->setCellValue('A' . $row, $userData['name']);
            $sheet->setCellValue('D' . $row, $attendance['present']);
            $sheet->setCellValue('E' . $row, $attendance['sick']);
            $sheet->setCellValue('F' . $row, $attendance['permission']);
            $sheet->setCellValue('G' . $row, $attendance['notAbsent']);
            $sheet->setCellValue('H' . $row, $attendance['check_in']);
            $sheet->setCellValue('I' . $row, $attendance['check_out']);
            $sheet->setCellValue('J' . $row, $attendance['latitude'] . ' , ' . $attendance['longitude']);
            $sheet->mergeCells('A' . $row . ':C' . $row);
            $sheet->mergeCells('J' . $row . ':L' . $row);
            $row++;
        }

        // hitung jumlah masuk,ijin sakit dll
        $sheet->setCellValue('A'.$row, 'total');
        $sheet->setCellValue('D'.$row, $attendances->sum('present'));
        $sheet->setCellValue('E'.$row, $attendances->sum('sick'));
        $sheet->setCellValue('F'.$row, $attendances->sum('permission'));
        $sheet->setCellValue('G'.$row, $attendances->sum('notAbsent'));

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
