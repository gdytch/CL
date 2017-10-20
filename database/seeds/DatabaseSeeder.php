<?php

use Illuminate\Database\Seeder;
use App\Admin;
class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        DB::table('admins')->insert(array(
            'username' => 'admin', 'password' => bcrypt('12345'), 'fname' => 'Admin', 'lname' => 'Demo', 'avatar' => 'default-avatar.png', 'theme' => 'green'
        ));
        
        DB::table('sections')->insert(array(
            array('id' => 1,  'name' => "URANUS-A",  'path' => "URANUS",  'created_at' => "2017-10-19 16:35:46",  'updated_at' => "2017-10-19 16:35:49",  'status' => true),
            array('id' => 2,  'name' => "URANUS-B",  'path' => "URANUS",  'created_at' => "2017-10-20 11:07:20",  'updated_at' => "2017-10-20 11:08:41",  'status' => true),
            array('id' => 3,  'name' => "PLUTO-A",  'path' => "PLUTO",  'created_at' => "2017-10-20 11:07:36",  'updated_at' => "2017-10-20 11:08:43",  'status' => true),
            array('id' => 5,  'name' => "NEPTUNE-A",  'path' => "NEPTUNE",  'created_at' => "2017-10-20 11:07:56",  'updated_at' => "2017-10-20 11:08:47",  'status' => true),
            array('id' => 6,  'name' => "NEPTUNE-B",  'path' => "NEPTUNE",  'created_at' => "2017-10-20 11:08:17",  'updated_at' => "2017-10-20 11:08:48",  'status' => true),
            array('id' => 7,  'name' => "SATURN-A",  'path' => "SATURN",  'created_at' => "2017-10-20 11:08:27",  'updated_at' => "2017-10-20 11:08:49",  'status' => true),
            array('id' => 8,  'name' => "SATURN-B",  'path' => "SATURN",  'created_at' => "2017-10-20 11:08:38",  'updated_at' => "2017-10-20 11:08:51",  'status' => true),
            array('id' => 4,  'name' => "PLUTO-B",  'path' => "PLUTO",  'created_at' => "2017-10-20 11:07:47",  'updated_at' => "2017-10-20 11:08:53",  'status' => true)
        ));
         DB::table('students')->insert(array(
             array('id' => 2, 'fname' => "Student2", 'lname' => "Demo", 'password' => bcrypt('123456'), 'section' => 2, 'path' => "Demo Student2", 'created_at' => "2017-10-20 11:17:33", 'updated_at' => "2017-10-20 11:17:33", 'avatar' => "default-avatar.png", 'last_login' => null, 'theme' => "green"),
             array('id' => 3, 'fname' => "Student1", 'lname' => "Demo", 'password' => bcrypt('123456'), 'section' => 1, 'path' => "Demo Student1", 'created_at' => "2017-10-20 11:18:25", 'updated_at' => "2017-10-20 11:18:25", 'avatar' => "default-avatar.png", 'last_login' => null, 'theme' => "green"),
             array('id' => 4, 'fname' => "Student3", 'lname' => "Demo2", 'password' => bcrypt('123456'), 'section' => 5, 'path' => "Demo2 Student3", 'created_at' => "2017-10-20 11:18:46", 'updated_at' => "2017-10-20 11:18:46", 'avatar' => "default-avatar.png", 'last_login' => null, 'theme' => "green"),
             array('id' => 5, 'fname' => "Student4", 'lname' => "Demo2", 'password' => bcrypt('123456'), 'section' => 4, 'path' => "Demo2 Student4", 'created_at' => "2017-10-20 11:19:16", 'updated_at' => "2017-10-20 11:19:16", 'avatar' => "default-avatar.png", 'last_login' => null, 'theme' => "green"),
             array('id' => 6, 'fname' => "Student5", 'lname' => "Demo3", 'password' => bcrypt('123456'), 'section' => 3, 'path' => "Demo3 Student5", 'created_at' => "2017-10-20 11:19:42", 'updated_at' => "2017-10-20 11:19:42", 'avatar' => "default-avatar.png", 'last_login' => null, 'theme' => "green"),
             array('id' => 7, 'fname' => "Student6", 'lname' => "Demo4", 'password' => bcrypt('123456'), 'section' => 7, 'path' => "Demo4 Student6", 'created_at' => "2017-10-20 11:20:06", 'updated_at' => "2017-10-20 11:20:06", 'avatar' => "default-avatar.png", 'last_login' => null, 'theme' => "green"),
        ));
        
            
        DB::table('posts')->insert(array(
             array(
             'id' => 1,
             'title' => "Activity 1",
             'draft' => false,
             'body' => '
               <ol>
               <li>Create a new spreadsheet</li>
               <li>Copy the data below</li>
               <li>Submit your work</li>
               </ol>
               <p><img alt="" src="https://drive.google.com/uc?export=view&amp;id=0B9-l5h4Py4DRbmVlV1ZRajRTOGc" /></p>
               ',
             'created_at' => "2017-10-19 16:42:50",
             'updated_at' => "2017-10-19 16:51:09",
           ),
           array(
             'id' => 2,
             'title' => "Activity 2",
             'draft' => false,
             'body' => '
               <p>1. Create a new spreadsheet file</p>
               <p>2. Copy the table below</p>
               <p>3. Create formulas to calculate the <strong>Total Exp</strong> (Total Expenditure).</p>
               <p>&nbsp; &nbsp; Ex. =B3+C3 <em>(<strong>Expenditure</strong> + <strong>Refund</strong>)</em></p>
               <p>4. Create formulas to calculate the <strong>Profit.</strong></p>
               <p>&nbsp; &nbsp; Ex. =E3-D3 <em>(<strong>Income</strong> - <strong>Total Exp</strong>)</em></p>
               <p>5. Create formulas to calculate the <strong>Totals</strong> for each column</p>
               <p>&nbsp;</p>
               <p><img alt="" src="https://drive.google.com/uc?export=view&amp;id=0B9-l5h4Py4DRMUVqQUc5cHN5UUU" /></p>
               ',
             'created_at' => "2017-10-19 17:20:36",
             'updated_at' => "2017-10-19 17:23:55",
           )
        ));

        DB::table('activities')->insert(array(
            array('id' => '6', 'name' => 'Activity 2', 'section_id' => '3', 'date' => '2017-10-20', 'submission' => true, 'description' => 'Charts 2', 'created_at' => '2017-10-20 11:12:11', 'updated_at' => '2017-10-20 11:12:11', 'active' => true, 'post_id' => null),
            array('id' => '7', 'name' => 'Activity 1', 'section_id' => '6', 'date' => '2017-10-19', 'submission' => true, 'description' => 'Charts', 'created_at' => '2017-10-20 11:12:43', 'updated_at' => '2017-10-20 11:12:43', 'active' => true, 'post_id' => null),
            array('id' => '8', 'name' => 'Activity 2', 'section_id' => '6', 'date' => '2017-10-20', 'submission' => true, 'description' => 'Charts 2', 'created_at' => '2017-10-20 11:13:04', 'updated_at' => '2017-10-20 11:13:04', 'active' => true, 'post_id' => null),
            array('id' => '9', 'name' => 'Activity 1', 'section_id' => '5', 'date' => '2017-10-19', 'submission' => true, 'description' => 'Charts', 'created_at' => '2017-10-20 11:13:21', 'updated_at' => '2017-10-20 11:13:21', 'active' => true, 'post_id' => null),
            array('id' => '10', 'name' => 'Activity 2', 'section_id' => '5', 'date' => '2017-10-20', 'submission' => true, 'description' => 'Charts 2', 'created_at' => '2017-10-20 11:13:51', 'updated_at' => '2017-10-20 11:13:51', 'active' => true, 'post_id' => null),
            array('id' => '15', 'name' => 'Activity 1', 'section_id' => '4', 'date' => '2017-10-19', 'submission' => true, 'description' => 'Charts', 'created_at' => '2017-10-20 11:15:55', 'updated_at' => '2017-10-20 11:15:55', 'active' => true, 'post_id' => null),
            array('id' => '16', 'name' => 'Activity 2', 'section_id' => '4', 'date' => '2017-10-20', 'submission' => true, 'description' => 'Charts 2', 'created_at' => '2017-10-20 11:16:13', 'updated_at' => '2017-10-20 11:16:13', 'active' => true, 'post_id' => null),
            array('id' => '1', 'name' => 'Activity 1', 'section_id' => '1', 'date' => '2017-10-19', 'submission' => true, 'description' => 'Getting Started with Spreadsheets', 'created_at' => '2017-10-19 16:36:57', 'updated_at' => '2017-10-20 11:16:41', 'active' => true, 'post_id' => '1'),
            array('id' => '11', 'name' => 'Activity 1', 'section_id' => '7', 'date' => '2017-10-19', 'submission' => true, 'description' => 'Getting Started with Spreadsheets', 'created_at' => '2017-10-20 11:14:07', 'updated_at' => '2017-10-20 11:16:41', 'active' => true, 'post_id' => '1'),
            array('id' => '13', 'name' => 'Activity 1', 'section_id' => '8', 'date' => '2017-10-19', 'submission' => true, 'description' => 'Getting Started with Spreadsheets', 'created_at' => '2017-10-20 11:14:46', 'updated_at' => '2017-10-20 11:16:41', 'active' => true, 'post_id' => '1'),
            array('id' => '3', 'name' => 'Activity 1', 'section_id' => '2', 'date' => '2017-10-19', 'submission' => true, 'description' => 'Getting Started with Spreadsheets', 'created_at' => '2017-10-20 11:10:25', 'updated_at' => '2017-10-20 11:16:41', 'active' => true, 'post_id' => '1'),
            array('id' => '2', 'name' => 'Activity 2', 'section_id' => '1', 'date' => '2017-10-19', 'submission' => true, 'description' => 'Creating Spreadsheets', 'created_at' => '2017-10-19 17:20:29', 'updated_at' => '2017-10-20 11:17:06', 'active' => true, 'post_id' => '2'),
            array('id' => '12', 'name' => 'Activity 2', 'section_id' => '7', 'date' => '2017-10-20', 'submission' => true, 'description' => 'Creating Spreadsheets', 'created_at' => '2017-10-20 11:14:30', 'updated_at' => '2017-10-20 11:17:06', 'active' => true, 'post_id' => '2'),
            array('id' => '14', 'name' => 'Activity 2', 'section_id' => '8', 'date' => '2017-10-20', 'submission' => true, 'description' => 'Creating Spreadsheets', 'created_at' => '2017-10-20 11:15:03', 'updated_at' => '2017-10-20 11:17:06', 'active' => true, 'post_id' => '2'),
            array('id' => '4', 'name' => 'Activity 2', 'section_id' => '2', 'date' => '2017-10-20', 'submission' => true, 'description' => 'Creating Spreadsheets', 'created_at' => '2017-10-20 11:10:55', 'updated_at' => '2017-10-20 11:17:06', 'active' => true, 'post_id' => '2'),
        ));

    }
}
