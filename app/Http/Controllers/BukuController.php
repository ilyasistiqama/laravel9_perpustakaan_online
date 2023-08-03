<?php

namespace App\Http\Controllers;

use App\Exports\MasterBukuExport;
use App\Exports\MasterBukuTemplateExport;
use App\Models\Buku;
use App\Models\Kategori;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Maatwebsite\Excel\Facades\Excel;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Style\Alignment;
use PhpOffice\PhpSpreadsheet\Style\Fill;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use RealRashid\SweetAlert\Facades\Alert;

class BukuController extends Controller
{
    public function index(Request $request)
    {
        $buku = Buku::latest();
        $search = null;
        $lengthChange = 10;
        if(isset($request->lengthChange)){
            $lengthChange = $request->lengthChange;
        }
        if(isset($request->search)){
            $search = strtolower($request->search);
            $buku = $buku->where(function($row) use ($search){
                $row->orWhere('isbn', 'like', "%$search%")
                    ->orWhere('judul', 'like', "%$search%");
            });
        }
        $buku = $buku->paginate($lengthChange);
        return view('pages.admin.master-buku',[
            'menu' => 'admin-master-buku',
            'buku' => $buku,
            'search' => $search,
            'lengthChange' => $lengthChange
        ]);
    }

    public function create()
    {
        $get_kategori = Kategori::latest()->get();
        return view('pages.admin.form.master-create-buku', [
            'menu' => 'admin-master-buku',
            'kategori' => $get_kategori,
            'judul' => 'Tambah',
            'buku' => []
        ]);
    }

    public function doStore(Request $request)
    {
        $request->validate([
            'jenis_kategori' => 'required',
            'judul' => 'required',
            'isbn' => 'required',
            'pengarang' => 'required',
            'jumlah_halaman' => 'required',
            'jumlah_stok' => 'required',
            'tahun_terbit' => 'required',
            'sinopsis' => 'required',
            'img' => 'image|mimes:jpeg,png,jpg'
        ]);

        $response = Buku::AddAndEditBuku($request);

        if($response->getData()->status == 200){
            Alert::success('Oke', $response->getData()->message);
            return redirect()->back();
        }else{
            Alert::error('Maaf', $response->getData()->message);
            return redirect()->back();
        }
    }

    public function show($id)
    {
        $get_buku = Buku::GetBukuById($id);

        return view('pages.admin.form.master-detail-buku', [
            'menu' => 'admin-master-buku',
            'judul' => 'Detail',
            'buku' => $get_buku   
        ]);
    }
    public function edit($id)
    {
        $get_buku = Buku::GetBukuById($id);
        $get_kategori = Kategori::latest()->get();

        return view('pages.admin.form.master-edit-buku', [
            'menu' => 'admin-master-buku',
            'kategori' => $get_kategori,
            'judul' => 'Edit',
            'buku' => $get_buku   
        ]);
    }

    public function doUpdate(Request $request, $id)
    {
        $request->validate([
            'jenis_kategori' => 'required',
            'judul' => 'required',
            'isbn' => 'required',
            'pengarang' => 'required',
            'jumlah_halaman' => 'required',
            'jumlah_stok' => 'required',
            'tahun_terbit' => 'required',
            'sinopsis' => 'required',
            'img' => 'image|mimes:jpeg,png,jpg'
        ]);

        $response = Buku::AddAndEditBuku($request, $id);

        if($response->getData()->status == 200){
            Alert::success('Oke', $response->getData()->message);
            return redirect()->back();
        }else{
            Alert::error('Maaf', $response->getData()->message);
            return redirect()->back();
        }
    }

    public function exportExcel()
    {
        return Excel::download(new MasterBukuExport, 'master-buku.xlsx');
    }

    public function exportPDF($id)
    {
        $buku = Buku::GetBukuById($id);
        $pdf = Pdf::loadView('pdf.master-detail-buku', compact('buku'));
        return $pdf->setPaper('a4', 'potrait')->setOptions(['defaultFont' => 'serif','isHtml5ParserEnabled' => true, 'isRemoteEnabled' => true])->stream();
    }

    public function TemplateImportExcel()
    {
        $spreadsheet = new Spreadsheet();
        $workSheetForm = new Worksheet($spreadsheet, 'Form');
        $spreadsheet->addSheet($workSheetForm, 0);
        $sheet = $spreadsheet->getSheetByName('Form');

        $sheet->mergeCells('A1:H1');
        $sheet->setCellValue('A1','Form Input Buku');
        $sheet->setCellValue('A2', 'Judul')->getColumnDimension('A')->setWidth(200, 'px');;
        $sheet->setCellValue('B2', 'ISBN')->getColumnDimension('B')->setWidth(120, 'px');;
        $sheet->setCellValue('C2', 'Pengarang')->getColumnDimension('C')->setWidth(120, 'px');;
        $sheet->setCellValue('D2', 'Jumlah Halaman')->getColumnDimension('D')->setWidth(120, 'px');;
        $sheet->setCellValue('E2', 'Jumlah Stok')->getColumnDimension('E')->setWidth(120, 'px');;
        $sheet->setCellValue('F2', 'Tahun Terbit (yyyy-dd-mm)')->getColumnDimension('F')->setWidth(200, 'px');;
        $sheet->setCellValue('G2', 'Sinopsis')->getColumnDimension('G')->setWidth(300, 'px');;
        $sheet->setCellValue('H2', 'Jenis Kategori (By ID From Worksheet Jenis Kategori)')->getColumnDimension('H')->setAutoSize(true);
        $sheet->getStyle('A1:H2')->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER)->setVertical(Alignment::VERTICAL_CENTER);
        $sheet->getStyle('A1:H2')->getFont()->setBold(true);
        $sheet->getStyle('A1:H2')->getFill()->setFillType(Fill::FILL_SOLID)->getStartColor()->setARGB('FFFF00');

        $workSheetKategori = new Worksheet($spreadsheet, 'Jenis Kategori');
        $spreadsheet->addSheet($workSheetKategori, 1);
        $sheet = $spreadsheet->getSheetByName('Jenis Kategori');
        
        $sheet->mergeCells('A1:B1');
        $sheet->setCellValue('A1','List Jenis Kategori');
        $sheet->setCellValue('A2', 'ID')->getColumnDimension('A')->setAutoSize(true);
        $sheet->setCellValue('B2', 'Kategori')->getColumnDimension('B')->setAutoSize(true);
        $sheet->getStyle('A1:B2')->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER)->setVertical(Alignment::VERTICAL_CENTER);
        $sheet->getStyle('A1:B2')->getFont()->setBold(true);
        $sheet->getStyle('A1:B2')->getFill()->setFillType(Fill::FILL_SOLID)->getStartColor()->setARGB('FFFF00');

        $kategori = Kategori::orderBy('id','asc')->get();
        
        $indexStart = 3;
        $index = 3;
        foreach ($kategori as $row) {
            $sheet->setCellValue('A' . $index, $row->id)->getColumnDimension('A')->setAutoSize(true);
            $sheet->setCellValue('B' . $index, $row->kategori)->getColumnDimension('B')->setAutoSize(true);
            $index++;
        }

        $sheet->getStyle('A' . $index . ':B' . $indexStart)->getAlignment()->setHorizontal(Alignment::HORIZONTAL_LEFT)->setVertical(Alignment::VERTICAL_CENTER);


        
        $sheet = $spreadsheet->setActiveSheetIndexByName('Form');

        $sheetIndex = $spreadsheet->getIndex(
            $spreadsheet->getSheetByName('Worksheet')
        );
        $spreadsheet->removeSheetByIndex($sheetIndex);

        $excel = new Xlsx($spreadsheet);
        $excel->save('Template-Import-Buku.xlsx');
        return redirect('Template-Import-Buku.xlsx');
    }

    public function doImport(Request $request)
    {
        if(!isset($request->file_excel)){
            Alert::error('Maaf', 'Upload File Excel Terlebih Dahulu.');
            return redirect()->back();
        }
        $response = Buku::ImportExcel($request);
        if($response->getData()->status == 200){
            Alert::success('Oke', $response->getData()->message);
            return redirect()->back();
        }else{
            Alert::error('Maaf', $response->getData()->message);
            return redirect()->back();
        }
    }

    public function doDelete(Request $request)
    {
        $id_encrypt = $request->input('id');
        $response = Buku::DeleteBukuById($id_encrypt);
        if($response->getData()->status == 200){
            Alert::success('Oke',$response->getData()->message);
            return redirect()->back();
        }else{
            Alert::error('Maaf',$response->getData()->message);
            return redirect()->back();
        }
    }
}
