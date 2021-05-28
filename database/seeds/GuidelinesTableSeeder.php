<?php

use Illuminate\Database\Seeder;

class GuidelinesTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
        

        \DB::table('guidelines')->delete();
        
        \DB::table('guidelines')->insert(array (
            0 => 
            array (
                'id' => 1,
                'role_id' => 4,
                'title' => 'Candidate',
                'description' => '<p><strong>Candidate Role Can do the following features:</strong></p>

<p>&nbsp;</p>

<ol>
<li>Entry the form:&nbsp; &nbsp;
<ul>
<li>The fom&nbsp; is seperated in to 6 steps(tabs) and&nbsp;&nbsp;candidate have to fill all information before submit.&nbsp;</li>
<li>
<p>Candidate can file some infomation and keep some&nbsp;infomation to fill next time by go to last tab( last step) then click on button &quot;save&quot; or click on button &quot;Save and continue&quot; in each steps. (check image below)</p>
</li>
<li>
<p>Candidate have to click on button &quot;Submit Final&quot; so that application will submit to&nbsp;country representer to review.&nbsp;</p>
</li>
<li>
<p>The form that submit final will not able edit unless Country Representer give some comment to update before daedline.&nbsp;</p>
</li>
<li>
<p>Check image below to see the needed infoamtion in 6 steps:</p>

<ul>
<li>
<p>Step 1 : Company Detail&nbsp;</p>

<p><img alt="company detail" src="/fmg/photos/shares/5d03bbe7b6c47.png" style="width:100%" /> <img alt="" src="/fmg/photos/shares/5d04659746397.png" style="width:100%" /></p>
</li>
<li>
<p>Step 2 : Contact person Detaiols</p>

<p><img alt="" src="/fmg/photos/shares/5d0465d5e1fb1.png" style="width:100%" /></p>
</li>
<li>
<p>Step 3 : Product Detail Part 1 &nbsp;</p>

<p><img alt="" src="/fmg/photos/shares/5d0466468deb7.png" style="width:100%" /><img alt="" src="/fmg/photos/shares/5d04665f45397.png" style="width:100%" /></p>
</li>
<li>
<p>Step 4&nbsp; Product Detail Part 2 &nbsp;</p>

<p><img alt="" src="/fmg/photos/shares/5d0466cf82cde.png" style="width:100%" /><img alt="" src="/fmg/photos/shares/5d0466e495f05.png" style="width:100%" /></p>
</li>
<li>
<p>Step 5: Video Demo Pro&nbsp;</p>

<p>Browse or Drag &amp; Drop the video demo about product&nbsp;</p>

<p><img alt="" src="/fmg/photos/shares/5d04670f5de7e.png" style="width:100%" /></p>
</li>
<li>
<p>Step 6 : Final</p>

<p>&nbsp;</p>

<p><img alt="" src="/fmg/photos/shares/5d0467452e308.png" style="width:100%" />&nbsp;</p>

<p>Remider:</p>

<ul>
<li>Save entry form as draft when you click on button &quot;save and continue&quot; in step 1 to step 5.</li>
<li>click on Submit Final if every onfomation is ready or click on save to save as draft.</li>
<li>Submit final form: Once you click on this button, you will not able to edit the entry form unless your application form has any comments from your country representer before dateline.
<p></p>
</li>
</ul>
</li>
</ul>
</li>
</ul>
</li>
<li>Profile
<p>&nbsp;</p>

<ul>
<li>change password<img alt="" src="/fmg/photos/shares/5d03bca2969b3.png" style="width:100%" />&nbsp;&nbsp;</li>
<li>edit profile &nbsp;
<p><img alt="" src="/fmg/photos/shares/5d03bc4ddb257.png" style="width:100%" /></p>
</li>
</ul>
</li>
</ol>

<p>&nbsp;</p>

<p>&nbsp;</p>',
                'status' => 'enabled',
                'created_at' => '2019-06-17 15:55:58',
                'updated_at' => '2019-06-18 03:56:21',
            ),
            1 => 
            array (
                'id' => 2,
                'role_id' => 3,
                'title' => 'Representer',
                'description' => '<p><strong>Representer &nbsp;Can the following features:</strong></p>

<ol>
<li>Candidate:
<ul>
<li>List canidate : show all candidate in the representer&#39;s country check image bellow&nbsp;<img alt="" src="/fmg/photos/shares/5d04694c3ec4b.png" style="width:100%" /></li>
<li>Create candidate : There is a button &quot;New Candidate&quot; in the image of list candidate, click on the button it will show a form as image bellow&nbsp;to create new candiate then fill all infomation and click on button &quot;save&quot; , a new candiate will created.&nbsp;<img alt="" src="/fmg/photos/shares/5d046964e9089.png" style="width:100%" />&nbsp;&nbsp;</li>
<li>Edit Candiate :&nbsp;There is a button with icon pencil&nbsp;in each row of table of image of list candidates, click on the button it will show a form as image bellow&nbsp;to create edit candiate then update&nbsp;infomation and click on button &quot;save&quot; , the&nbsp;candiate will update.<img alt="" src="/fmg/photos/shares/5d04697de6362.png" style="width:100%" /></li>
<li>Delete candidate :&nbsp;There is a button with icon trash&nbsp;in each row of table of image of list candidates, click on the button it will show a popup alert as image bellow&nbsp;to confirm delete candiate. click on button &quot;Yes, delete&quot; to Delete candiate or click on icon &quot;No, Cancel&quot; to cancel deleting. <big>Note</big>: candidate can be delete only when candidate never fill the application form, otherwish Country representer have to contact to admin to delete.<img alt="" src="/fmg/photos/shares/5d0469b12e38a.png" style="width:100%" /></li>
<li>&nbsp;</li>
</ul>
</li>
<li>Application&nbsp;
<ul>
<li>List application:&nbsp;show all application that candiate submit&nbsp;in the representer&#39;s country check image bellow.<img alt="" src="/fmg/photos/shares/5d04b76031945.png" style="width:100%" /></li>
<li>View application: In each row of table in list application there is button with icon &quot;sandwich&quot; or list&nbsp;&nbsp;then click on the icon to review the infomation that candiate fill. there are 6 tabs of in fomation to view and representer can be either click tab icon or buttun next to view other tabs of innformation. Representer can also comment or feedback the application on the right side,&nbsp;check images all tabs bellow:&nbsp;<img alt="" src="/fmg/photos/shares/5d04726c1bc82.png" style="width:100%" /><img alt="" src="/fmg/photos/shares/5d0472969834e.png" style="width:100%" /><img alt="" src="/fmg/photos/shares/5d0472afbedb0.png" style="width:100%" /><img alt="" src="/fmg/photos/shares/5d0472c27b0fa.png" style="width:100%" /><img alt="" src="/fmg/photos/shares/5d0472dab444b.png" style="width:100%" /><img alt="" src="/fmg/photos/shares/5d0472ed79d43.png" style="width:100%" /><img alt="" src="/fmg/photos/shares/5d047302a2785.png" style="width:100%" /></li>
<li>Accept application :&nbsp;In each row of table in list application there is button with icon &quot;check&quot; then click on the icon(button), it will show an alert popup&nbsp; to confirm&nbsp;accept application&nbsp;for asean judging list (online judging list or semi final judging list), if click button &quot; Yes, accept&quot; application goes to ASEAN list otherwhich click on button &quot;No, cancel&quot; . <strong>Be warning , </strong>once an application accepted Representer will not abled to see application anymore.<img alt="" src="/fmg/photos/shares/5d04beefb3b00.png" style="width:100%" /></li>
</ul>
</li>
<li>Profile
<ul>
<li>&nbsp;&nbsp;View profile<img alt="" src="/fmg/photos/shares/5d0468d4d7d6a.png" style="width:100%" /></li>
<li>Edit Profile<img alt="" src="/fmg/photos/shares/5d0468b359967.png" style="width:100%" /></li>
<li>Change Password<img alt="" src="/fmg/photos/shares/5d046899172f3.png" style="width:100%" /></li>
</ul>
</li>
</ol>

<p>&nbsp;</p>

<p>&nbsp;</p>

<p>&nbsp;</p>

<p>&nbsp;</p>

<p>&nbsp;</p>',
                'status' => 'enabled',
                'created_at' => '2019-06-17 15:57:05',
                'updated_at' => '2019-06-17 15:57:05',
            ),
            2 => 
            array (
                'id' => 3,
                'role_id' => 1,
                'title' => 'Guideline for Admin',
                'description' => '<p>Admin Role Can use the follow feature:</p>

<ol>
<li>User
<ul>
<li>List all users: Users can be Admin or Representer<img alt="" src="/fmg/photos/shares/user list admin.png" style="width:100%" /></li>
<li>Create new user:&nbsp;There is a button &quot;New User&quot; in the image of list users, click on the button it will show a form as image bellow&nbsp;to create new user then fill all infomation and click on button &quot;save&quot; , a new user will create.&nbsp;<img alt="" src="/fmg/photos/shares/user create.png" style="width:100%" /></li>
<li>Edit user :There is a button with icon pencil&nbsp;in each row of table of image of list users, click on the button it will show a form as image bellow&nbsp;to create edit user then update&nbsp;infomation and click on button &quot;save&quot; , the&nbsp;user will update.<img alt="" src="/fmg/photos/shares/user edit.png" style="width:100%" /></li>
<li>Delete user:&nbsp;There is a button with icon trash&nbsp;in each row of table of image of list users, click on the button it will show a popup alert as image bellow&nbsp;to confirm delete user. click on button &quot;Yes, delete&quot; to Delete user or click on icon &quot;No, Cancel&quot; to cancel deleting.&nbsp;<img alt="" src="/fmg/photos/shares/user delete.png" style="width:100%" /></li>
</ul>
</li>
<li>Candiate&nbsp;
<ul>
<li>List all Candidates :&nbsp;show all candidate in the system check image bellow<img alt="" src="/fmg/photos/shares/candiate list_1.png" style="width:100%" /></li>
<li>Create new candidate :&nbsp;There is a button &quot;New Candidate&quot; in the image of list candidate, click on the button it will show a form as image bellow&nbsp;to create new candiate then fill all infomation and click on button &quot;save&quot; , a new candiate will created.&nbsp;<img alt="" src="/fmg/photos/shares/candidate create.png" style="width:100%" /></li>
<li>Edit candidate:&nbsp;There is a button with icon pencil&nbsp;in each row of table of image of list candidates, click on the button it will show a form as image bellow&nbsp;to create edit candiate then update&nbsp;infomation and click on button &quot;save&quot; , the&nbsp;candiate will update.<img alt="" src="/fmg/photos/shares/candidate edit.png" style="width:100%" /></li>
<li>Delete candidate:&nbsp;There is a button with icon trash&nbsp;in each row of table of image of list candidates, click on the button it will show a popup alert as image bellow&nbsp;to confirm delete candiate. click on button &quot;Yes, delete&quot; to Delete candiate or click on icon &quot;No, Cancel&quot; to cancel deleting.&nbsp;<strong><big>Note</big></strong>: Delete candidate carefully or use this function only if country representer request.<img alt="" src="/fmg/photos/shares/candidate confirm delete.png" style="width:100%" /></li>
</ul>
</li>
<li>Judge
<ul>
<li>List all jusges<img alt="" src="/fmg/photos/shares/5d07add0bb53a.png" style="width:100%" /></li>
<li>Create Judge</li>
<li>Edit Judge</li>
<li>Delete Judge</li>
</ul>
</li>
<li>Application
<ul>
<li>List all applications<img alt="" src="/fmg/photos/shares/5d07ae20f0063.png" style="width:100%" /></li>
<li>Review application : just the same as representer Guideline please check Representer Guidline.</li>
<li>Review Video demo: watch video demo without view any other information by click on icon play in each row that video availible. Image bellow it the screen of video demo.<img alt="" src="/fmg/photos/shares/5d07af55cbd8f.png" style="width:100%" /></li>
<li>Accept application :&nbsp; just the same as representer Guideline please check Representer Guidline.</li>
</ul>
</li>
<li>Asean Application
<ul>
<li>List application : all application that is accepted will availible here.</li>
<li>view video: just the same as link video of application list</li>
</ul>
</li>
<li>Profile&nbsp;
<ul>
<li>View profile:&nbsp;Generaly , system will open profile page after login. if you are at other page then you can click on peofile menu on the left menu.&nbsp; on page profile, you can edit profile by click button &quot;edit Profile&quot; (check image below) then system will go to editable page.<img alt="" src="/fmg/photos/shares/Screen Shot 2019-06-13 at 12.41.01 AM.png" style="width:100%" /></li>
<li>Edite profile<img alt="" src="/fmg/photos/shares/profile edits.png" style="width:100%" /></li>
<li>Change password<img alt="" src="/fmg/photos/shares/change password.png" style="width:100%" /></li>
</ul>
</li>
<li>Setting : The configuration will be in the setting block, Example : SATART_JUDGING_DATE is the date that Judage of Online Judging can start to judge.
<ul>
<li>List Settings<img alt="" src="/fmg/photos/shares/setting list.png" style="width:100%" /></li>
<li>Edit : Warning: Do not edit any settings if don&#39;t know what it does. Suggest edit the settings in type date only because admin may need to update a few setting related to date such as
<ul>
<li>When dateline of form summition</li>
<li>when judge can start to Judge the online Judging</li>
<li>when the dateline of online judging</li>
<li>when Final judge can judge</li>
</ul>
</li>
<li>Create: You can create any setting but it may&nbsp; useless&nbsp; or not affect to the system&nbsp;</li>
<li>Delete : Warning , Do not delete any existing setting , otherwhish the system may crush.</li>
</ul>
</li>
</ol>

<ul>
<li>&nbsp;</li>
</ul>

<p>&nbsp;</p>

<p>&nbsp;</p>

<p>&nbsp;</p>

<p>&nbsp;</p>

<p>&nbsp;</p>',
                'status' => 'enabled',
                'created_at' => '2019-06-17 15:59:44',
                'updated_at' => '2019-06-17 15:59:44',
            ),
            3 => 
            array (
                'id' => 4,
                'role_id' => 5,
                'title' => 'Judge',
                'description' => '<p><strong>Judge can do some following features:</strong></p>

<ol>
<li><strong>Asean Application:</strong>

<ol>
<li><strong>&nbsp;</strong>This menu is for listing all the accepted application form of candidates that related to your&nbsp;responsibled categories.</li>
<li>There are two tabs as below:&nbsp;
<ul>
<li>Pending Judging: It means that all the applications listed below are not yet judged by the judge.<img alt="" src="/fmg/photos/shares/5d36d3479ef1e.png" style="height:100%; width:100%" /></li>
<li>Judging Completed: If judge provides score in the criteria form and submit, it will move that application form to this tab. You can also provide the score again if the deadline is not yet on time.<img alt="" src="/fmg/photos/shares/5d36d96176ee8.png" style="height:100%; width:100%" /></li>
</ul>
</li>
<li>In activity column there are 3 actions that judge can do:
<ol>
<li><strong>Review application:</strong> It is the first icon in the activity column, Judge can view detail on information of application form.<img alt="" src="/fmg/photos/shares/5d36dc67597f2.png" style="height:100%; width:100%" /></li>
<li><strong>View Video:&nbsp;</strong>The second icon in the activity column, Judge can view and play video of candidate.<img alt="" src="/fmg/photos/shares/5d36dcafd21f7.png" style="height:100%; width:100%" /></li>
<li><strong>Judge:</strong> The last icon in the activity column, Judge must provide score in the criteria box.<img alt="" src="/fmg/photos/shares/5d36dcf625666.png" style="height:100%; width:100%" />The&nbsp;criteria for judge, please check in the this link :&nbsp;<a href="https://aseanictaward.com/index.php/judging-guidelines/general-judging-criteria/">https://aseanictaward.com/index.php/judging-guidelines/general-judging-criteria/</a></li>
</ol>
</li>
</ol>
</li>
<li><strong>Result:&nbsp;</strong>Judge can see the final result of online judging due to the date assigned.</li>
<li><strong>Guidline:&nbsp;</strong>Judge can see the guidline of responsible task of judge only.</li>
<li><strong>Profile:&nbsp;</strong>Judge can view and edit his own information.<img alt="" src="/fmg/photos/shares/5d3808677ad91.png" style="height:100%; width:100%" /></li>
<li><strong>Change Password:&nbsp;</strong>Judge can change his/her&nbsp;own password.<img alt="" src="/fmg/photos/shares/5d380d05b314b.png" style="height:100%; width:100%" /></li>
</ol>',
                'status' => 'enabled',
                'created_at' => '2019-07-23 20:23:32',
                'updated_at' => '2019-07-24 18:48:01',
            ),
            4 => 
            array (
                'id' => 5,
                'role_id' => 6,
                'title' => 'Final Judging',
                'description' => '<p><strong>Final Judge can do some following features:</strong></p>

<ol>
<li><strong>Final Judging:</strong>

<ol>
<li>
<p><strong>&nbsp;</strong>This menu is for listing all the application form of candidates that will be selected for first, second, and third place. You can also filter the form by category by choosing the category in the selection box.<img alt="" src="/fmg/photos/shares/5d382a620a469.png" style="height:100%; width:100%" /></p>
</li>
<li>In activity column there are 3 actions that judge can do:
<ol>
<li>
<p><strong>View Video:&nbsp;</strong>The first icon in the action column, Judge can view and play video of candidate.<img alt="" src="/fmg/photos/shares/5d382a945c291.png" style="height:100%; width:100%" /></p>
</li>
<li>
<p><strong>Review application:</strong> It is the second icon in the action column, Judge can view detail on information of application form.<img alt="" src="/fmg/photos/shares/5d382b1dda28c.png" style="height:100%; width:100%" /></p>
</li>
<li>
<p><strong>Judge:</strong> The last icon in the action column, Judge must provide score in the criteria box but not zero. The&nbsp;criteria for judging, please check in this link :&nbsp;<a href="https://aseanictaward.com/index.php/judging-guidelines/general-judging-criteria/">https://aseanictaward.com/index.php/judging-guidelines/general-judging-criteria/</a>. During the process of providing score or after you submit the score, the medal will generate automatically. In one category judge cannot provide the same medal. If&nbsp;this case is happend, judge must change the score.<img alt="" src="/fmg/photos/shares/5d382ba261280.png" style="height:100%; width:100%" /></p>
</li>
</ol>
</li>
</ol>
</li>
<li><strong>Result:&nbsp;</strong>Judge can see the final result of final judging after the freez button is clicked by the administrator.</li>
<li><strong>Guidline:&nbsp;</strong>Judge can see the guidline of responsible task of final judge only.</li>
<li><strong>Profile:&nbsp;</strong>Judge can view and edit his own information.<img alt="" src="/fmg/photos/shares/5d382c0979190.png" style="height:100%; width:100%" /></li>
<li><strong>Change Password:&nbsp;</strong>Judge can change his/her&nbsp;own password.<img alt="" src="/fmg/photos/shares/5d382c4de3f9a.png" style="height:100%; width:100%" /></li>
</ol>',
                'status' => 'enabled',
                'created_at' => '2019-07-24 18:57:27',
                'updated_at' => '2019-07-24 21:01:36',
            ),
        ));
        
        
    }
}