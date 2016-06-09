<?php
	echo validation_errors();

	echo form_open( base_url() . 'account/create');
	$field = array();
	$field['firstname'] = array(
              'name'        => 'firstname',
              'id'          => 'firstname',
              'value'       => '',
              'maxlength'   => '100',
              'size'        => '50',
              'class'       => 'textfield',
              'required'    => false
            );

	$field['middlename'] = array(
              'name'        => 'middlename',
              'id'          => 'middlename',
              'value'       => '',
              'maxlength'   => '100',
              'size'        => '50',
              'class'       => 'textfield',
              'required'    => false
            );

	$field['lastname'] = array(
              'name'        => 'lastname',
              'id'          => 'lastname',
              'value'       => '',
              'maxlength'   => '100',
              'size'        => '50',
              'class'       => 'textfield',
              'required'    => false
            );

	$field['gender'] = array(
			  ''        => 'Please select Gender',
              'male'        => 'Male',
              'female'          => 'Female'
            );

	$field['maritalstatus'] = array(
			  ''        => 'Please select Marital Status',
              'single'        => 'Single',
              'married'          => 'Married',
              'widower'          => 'windower'
            );

	$field['spousename'] = array(
              'name'        => 'spousename',
              'id'          => 'spousename',
              'value'       => '',
              'maxlength'   => '100',
              'size'        => '50',
              'class'       => 'textfield',
            );

  //placement
  $field['placements'] = array();
  foreach ($placements as $line) {
    $field['placement'][$line['eid']] = $line['firstname'] . ' ' . $line['lastname'] . ' Entry No ' . $line['eno'];
  }


  //data from entries
  $field['referrers'] = array();
  foreach ($referrers as $line) {
    $field['referrers'][$line['id']] = $line['firstname'] . ' ' . $line['lastname'];
  }

  echo form_label('Referrer ID', 'referrer');
  echo form_dropdown( 'referrer', $field['referrers'] );
  echo '<br>';

  echo form_label('Placement ID', 'placement');
  echo form_dropdown( 'placement', $field['placement'] );
  echo '<br>';

	echo form_label('First Name', 'firstname');
	echo form_input( $field['firstname'] );
	echo '<br>';

	echo form_label('Last Name', 'lastname');
	echo form_input( $field['lastname'] );
	echo '<br>';

	// echo form_label('Middle Name', 'middlename');
	// echo form_input( $field['middlename'] );
	// echo '<br>';

	// echo form_label('Gender', 'gender');
	// echo form_dropdown( 'gender', $field['gender'] );
	// echo '<br>';

	// echo form_label('Marital Status', 'maritalstatus');
	// echo form_dropdown( 'maritalstatus' , $field['maritalstatus'] );
	// echo '<br>';

	// echo form_label('Spouse Name', 'spousename');
	// echo form_input( $field['spousename'] );
	// echo '<br>';

	echo form_submit('submit','Create');

	echo form_close();