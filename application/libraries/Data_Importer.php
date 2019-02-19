<?php
defined('BASEPATH') or exit('No direct script access allowed');

/**
 * Library to import data from .csv files
 */
class Data_importer
{
    public function __construct()
    {
        include(APPPATH.'third_party'.'/'.'PhpExcel'.'/'.'PHPExcel'.'/'.'IOFactory.php');
    }



    /**
     * Import data from .csv file to a single table.
     * Reference: http://csv.thephpleague.com/
     *
     * Sample usage:
     * 	$fields = array('name', 'email', 'age', 'active');
     *  $this->load->library('data_importer');
     *  $this->data_importer->csv_import('data.csv', 'users', $fields, TRUE);
     */

    public function csv_import($file, $table, $fields, $clear_table = false, $delimiter = ',', $skip_header = true)
    {
        $CI =& get_instance();
        $CI->load->database();

        // prepend file path with project directory
        $reader = League\Csv\Reader::createFromPath(FCPATH.$file);
        $reader->setDelimiter($delimiter);

        // (optional) skip header row
        if ($skip_header) {
            $reader->setOffset(1);
        }

        // prepare array to be imported
        $data = array();
        $count_fields = count($fields);
        $query_result = $reader->query();
        foreach ($query_result as $idx => $row) {
            // skip empty rows
            if (!empty($row[0])) {
                $temp = array();
                for ($i=0; $i<$count_fields; $i++) {
                    $name = $fields[$i];
                    $value = $row[$i];
                    $temp[$name] = $value;
                }
                $data[] = $temp;
            }
        }

        // (optional) empty existing table
        if ($clear_table) {
            $CI->db->truncate($table);
        }

        // confirm import (return number of records inserted)
        return $CI->db->insert_batch($table, $data);
    }


    public function trainer_import_xls($file)
    {
      $CI =& get_instance();
      $CI->load->database();

      // siapkan file path
      $excel = PhpExcel_IOFactory::load($file)
      foreach ($excel->getWorksheetIterator() as $worksheet)
      {
        $highestRow = $worksheet->getHighestRow();
        for($row=2; $row <= $highestRow, $row++)
        {
          $ummi_daerah_id       = $worksheet->getCellByColumnAndRow(0, $row)->getValue();
          $nama_trainer         = $worksheet->getCellByColumnAndRow(1, $row)->getValue();
          $nama_panggilan       = $worksheet->getCellByColumnAndRow(2, $row)->getValue();
          $alamat_lengkap       = $worksheet->getCellByColumnAndRow(3, $row)->getValue();
          $no_hp                = $worksheet->getCellByColumnAndRow(4, $row)->getValue();
          $email                = $worksheet->getCellByColumnAndRow(5, $row)->getValue();
          $tanggal_lahir        = $worksheet->getCellByColumnAndRow(6, $row)->getValue();
          $pendidikan_terakhir  = $worksheet->getCellByColumnAndRow(7, $row)->getValue();

          $data[] = array(
            'ummi_daerah_id'      => $ummi_daerah_id,
            'nama_trainer'        => $nama_trainer
            'nama_panggilan'      => $nama_panggilan,
            'alamat_lengkap'      => $alamat_lengkap,
            'no_hp'               => $no_hp,
            'email'               => $email,
            'tanggal_lahir'       => $tanggal_lahir,
            'pendidikan_terakhir' => $pendidikan_terakhir
          );
        }
      }
      $CI->db->trans_start();
      $CI->db->insert_batch('trainer', $data);
      $CI->db->trans_complete();

      if ($CI->db->trans_status() === FALSE)
      {
          $CI->message->custom_error_msg('', 'Import Data Gagal');
      }else{
          $CI->message->custom_success_msg('', 'Import Data Berhasil');
      }

    }



}
