<?php

class Upload extends CI_Controller {

        public function __construct()
        {
                parent::__construct();
                $this->load->helper(array('form', 'url'));
        }

        public function index()
        {
            $this->load->view('upload_form', array('error' => ' ' ));
        }

        public function do_upload()
        {
        $original_path = './uploads/ILLUS-RACINE29.jpg';
        $resized_path = './uploads/';
        $thumbs_path = './uploads/';
        $this->load->library('image_lib');

        $config = array(
            'allowed_types' => 'jpg|jpeg|gif|png', //only accept these file types
            'max_size' => 2048, //2MB max
            'upload_path' => $original_path //upload directory    
        );
        $this->load->library('upload', $config);
        $this->upload->do_upload();
        $image_data = $this->upload->data(); //upload the image
        $image1 = $image_data['file_name'];

        //your desired config for the resize() function
        $config = array(
            'source_image' => $image_data['full_path'], //path to the uploaded image
            'new_image' => $resized_path,
            'maintain_ratio' => true,
            'width' => 128,
            'height' => 128
        );
        $this->image_lib->initialize($config);
        $this->image_lib->resize();

        // for the Thumbnail image
        $config = array(
            'source_image' => $image_data['full_path'],
            'new_image' => $thumbs_path,
            'maintain_ratio' => true,
            'width' => 36,
            'height' => 36
        );
        //here is the second thumbnail, notice the call for the initialize() function again
        $this->image_lib->initialize($config);

        $this->image_lib->resize();
        //$this->image_lib->clear();
       	echo  $this->image_lib->display_errors();
        die();




                $this->load->library('upload', $config);

                if ( ! $this->upload->do_upload('userfile'))
                {
                        $error = array('error' => $this->upload->display_errors());

                        $this->load->view('upload_form', $error);
                }
                else
                {
                        $data = array('upload_data' => $this->upload->data());

                        $config['image_library'] = 'gd2';
						$config['source_image'] = './uploads/'.$data['upload_data']['file_name'];
						$config['create_thumb'] = TRUE;
						$config['maintain_ratio'] = TRUE;
						$config['width']         = 75;
						$config['height']       = 50;
						$this->load->library('image_lib', $config);
						$this->image_lib->resize();

						echo $this->image_lib->display_errors();
                       	$this->load->view('upload_success', $data);
                }
        }
}
?>
