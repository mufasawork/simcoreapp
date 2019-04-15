<?php defined("BASEPATH") or exit("No direct script access allowed");

/**
 * Import Controller.
 */
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

class Import extends MY_Controller
{
    private $title;
    private $filename = 'import_mun_file';

    public function __construct()
    {
        parent::__construct();

        $this->title = "Import Peserta Munaqasyah";
        $this->load->model('ImportModel');
    }

    public function form($code)
    {
        $munaqasyah = db_get_row('tm_munaqasyah', array('code' => $code));
        if(!isset($munaqasyah)){
            $this->message->custom_error_msg('munaqasyah/data','Error: Kode tidak ditemukan');
        }

        if(isset($_POST['preview']))
        {
            $upload = $this->ImportModel->upload_file($this->filename);

            if($upload['result'] == 'success')
            {

                include APPPATH.'third_party/PHPExcel/PHPExcel.php';

                $excelreader = new PHPExcel_Reader_Excel2007();
                $loadexcel = $excelreader->load('excel/'.$this->filename.'.xlsx'); // Load file yang tadi diupload ke folder excel
                $sheet = $loadexcel->getActiveSheet()->toArray(null, true, true, true);

                $data['sheet'] = $sheet;
                $data['code'] = $code;

            } else {
                $this->message->custom_error_msg('munaqasyah/import/form/'.$code,'Error: Extensi file yang diijinkan hanya .xlsx cek file anda');
            }

        }

        $this->layout->set_wrapper('import_form', $data, 'page', false);

        $template_data["title"] = "Import Peserta Munaqasyah";
        $template_data["crumb"] = [
          "Munaqasyah" => "",
          "Import" => ""
        ];
        $this->layout->render('admin', $template_data); // front - auth - admin
        $this->layout->auth();

    }

    public function save()
    {
        // Load plugin PHPExcel nya
        include APPPATH.'third_party/PHPExcel/PHPExcel.php';

        $excelreader = new PHPExcel_Reader_Excel2007();
        $loadexcel = $excelreader->load('excel/'.$this->filename.'.xlsx'); // Load file yang telah diupload ke folder excel
        $sheet = $loadexcel->getActiveSheet()->toArray(null, true, true, true);

        // Buat sebuah variabel array untuk menampung array data yg akan kita insert ke database
        $data = array();
        $code = $this->input->post('code');
        $munaqasyah = db_get_row('tm_munaqasyah', array('code' => $code));
        $munaqasyah_id = $munaqasyah->id_munaqasyah;

        $numrow = 1;

        foreach ($sheet as $row) {
          // code...
          if ($numrow > 1) {
              $valid_date = implode("-", array_reverse(explode("-", $row['C'])));

              // get data from row
              $data = array(
                'munaqasyah_id' => $munaqasyah_id,
                'nama_lengkap' => $row['A'],
                'tempat_lahir' => $row['B'] ,
                'tanggal_lahir' => $valid_date,
                'alamat' => $row['D'] ,
                'kelas' => $row['E']
              );


              // input to trainer table
              $this->db->insert('tm_peserta_munaqasyah', $data);

              // notification  IMPORT_PESERTA_MUNAQASYAH BARU

          }

          $numrow++;
        }

        redirect('munaqasyah/peserta/'.$code);
    }

}
