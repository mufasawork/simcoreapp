<?php defined("BASEPATH") or exit("No direct script access allowed");

/**
 * Profile Controller.
 */
class Profile extends MY_Controller
{
    private $title;

    public function __construct()
    {
        parent::__construct();

		    $this->title = "Profil Trainer";
    }

    /**
     * Index
     */
    public function index()
    {
    if(empty($this->input->get('trainerid'))){
      $user_info = $this->ion_auth->user()->row();
      $additional_data = json_decode($user_info->additional)[0];
      $trainerid = $additional_data->trainer_id;
    } else {
      $trainerid = $this->input->get('trainerid');
    }

    $trainer = db_get_row('trainer',array('id_trainer' => $trainerid));

    $data = array(
      'data' => $trainer
    );

    // $this->layout->set_wrapper( 'profile', $data, 'page', false);

    print_r($data);


    // $template_data["title"] = $title;
		// $template_data["crumb"] = ["Trainer" => "", "Profile" => ""];
		// $this->layout->auth();
		// $this->layout->render('admin', $template_data);
    }
}
