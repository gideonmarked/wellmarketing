<?php namespace Grinkomeda\Enrollment\Updates;

use Schema;
use October\Rain\Database\Updates\Migration;

class CreateCurriculumsTable extends Migration
{

    public function up()
    {
        Schema::create('grinkomeda_enrollment_curriculums', function($table)
        {
            $table->engine = 'InnoDB';
            $table->increments('id');
            $table->string('school_year');
            $table->timestamps();
        });

        Schema::create('grinkomeda_enrollment_curriculums_subjects', function($table)
        {
            $table->engine = 'InnoDB';
            $table->integer('curriculum_id')->unsigned();
            $table->integer('subject_id')->unsigned();
            $table->integer('level_id')->unsigned();
            $table->primary(['curriculum_id', 'subject_id'], 'curriculum_subject');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('grinkomeda_enrollment_curriculums');
        Schema::dropIfExists('grinkomeda_enrollment_curriculums_subjects');
    }

}
