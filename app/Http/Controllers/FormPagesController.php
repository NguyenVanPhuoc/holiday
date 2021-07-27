<?php
namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Http\Requests;
use App\Pages;
use Mail;
use App\Metas;
use App\SlideDetail;
use App\ArticleCat;
use App\Article;
use App\Countries;
use App\CategoryTour;
use App\MediaCat;
use App\Media;
use Illuminate\Support\Facades\Auth;
class FormPagesController extends Controller
{  
    /**
    * Display content contact page   
    */
    public function contact(){
        $page = Pages::find(15);
        $seo = get_seo(15,'page');
        $data = [
            'page'=> $page,
            'seo'=> $seo,
        ];
        return view('form.contact', $data);
    }
    /*
    * Display content sectup call phone page   
    */
    public function setupCallPhone(){
        return view('form.setup_phone_call');
    }
    /*
    * Display content create my trip
    */
    public function createMyTrip(){
        $page = Pages::find(30);
        $seo = get_seo(30,'page');
        $data = [
            'page'=> $page,
            'seo'=> $seo,
        ];
        return view('form.create_my_trip', $data);
    }
    /*
    * Display content personalize
    */
    public function createPersonalize(){
        $page = Pages::find(31);
        $seo = get_seo(31,'page');
        $data = [
            'page'=> $page,
            'seo'=> $seo,
        ];
        return view('form.personalize', $data);
    }
    /*
    * Display content Feedback
    */
    public function createFeedback(){
        $page = Pages::find(32);
        $seo = get_seo(32,'page');
        $data = [
            'page'=> $page,
            'seo'=> $seo,
        ];
        return view('form.feedback', $data);
    }
    /*
    * Send mail contact by ajax
    */
    public function updateContact(Request $request){
        if($request->ajax()):
            $fullName = $request->fullName;
            $email = $request->email;
            //$ageGroup = $request->ageGroup;
            //$country = $request->country;
            $newsletter = $request->newsletter;
            $phone = $request->numberPhone;
            $subject = $request->subject;
            $message = $request->message;
            //$titleIntro = $request->titleIntro;
            //$firstNameIntro = $request->firstNameIntro;
            //$lastNameIntro = $request->lastNameIntro;
            $phoneSystem = phone();
            $mailSystem = mailSystem();
            $domain = $request->getHost();
            // content
            if(!empty($fullName) && !empty($email) && !empty($phone) && !empty($subject) && !empty($message)) : 
                $h3 = 'font-size: 16px;line-height:31px;background-color:#666;border-radius: 10px; margin: 0;color: #fff;text-align: center; ';
                $fleft = 'float: left; width: 100%;';
                $overflow = 'overflow: hidden';
                $wrapper = 'font-size: 15px; line-height: 21px; color: #666; font-family: Arial; background-color: #fff; width: 600px; margin: 0 auto; -webkit-overflow-scrolling: touch; overflow: auto;';
                $header = 'width: 100%;';
                $logo ='display: block';
                $container_fluid = 'padding: 0 40px;';
                $box_modal = 'padding: 10px; text-align: left;';
                $box_modal_ul = 'padding-left: 25px; margin: 0;';
                $box_modal_p_li = 'color: #555; position: relative; margin-left: 0;';   
                $about_box = 'background-color: #f1f1f1;padding:18px 34px 44px; text-align: center; border-bottom-right-radius: 10px; border-bottom-left-radius: 10px;';
                $about_box_ul = 'padding-left:0 ;list-style: none; margin: 0; color: #7e7e7e;';
                $about_box_info_li = 'margin-bottom: 22px; display: block; margin-left: 0;';
                $list_button = 'margin-top: 25px;';
                $list_button_2 = 'margin-bottom: 25px; background-color:#f1f1f1; padding: 20px 0; border-radius:10px;';
                $list_button_li = 'text-align: center;  margin: 0 0 15px 0;';
                $list_button_li_right = 'text-align: center; margin: 0 ;';
                $list_button_li_a = 'display: block; width: 300px; max-width: 100%; line-height: 33px; background-color: #e73361;color: #fff; border-radius: 10px; text-decoration: none; margin: 0 auto;';
                $list_button_li_a_right = 'display: block; width: 300px; max-width: 100%; line-height: 33px;background-color: #34e6d0;color: #fff; border-radius: 10px; text-decoration: none;  margin: 0 auto;';
                $red_color = 'color: #e73362';
                $button_group = 'background-color: #f1f1f1; margin-bottom: 50px; border-radius: 10px;';
                $share_box = 'background-color: #f1f1f1; border-top-left-radius: 10px; border-top-right-radius: 10px;';
                $share_h3 = 'color: #666; font-size: 14px; line-height: 20px; margin: 19px 0 25px; text-align: center;';
                $share_ul = 'overflow: hidden;';
                $share_li = 'float:left; width: 20%; max-width: 100%; max-height: 100%; margin: 0  auto; box-sizing: border-box; margin-bottom: 15px;';
                $share_li_a = 'width: 30px; height: 30px; line-height: 30px; text-align: center; max-width: 100%; margin: 0 auto; background-color: #e73361; border-radius: 5px; display: block;';
                $footer = 'background-color: #666; clear: both;';
                $footer_ul = 'overflow:hidden; padding: 20px 0;';
                $footer_li = 'width: 50%; float: left; color: #fff; max-width: 100%; max-height: 100%; margin: 0  auto; box-sizing: border-box; text-align: center;';
                $footer_li_a = 'color: inherit; text-decoration: underline; font-size: 14px;';
                $footer_span = 'border-radius: 50%; width: 25px; height: 25px; line-height: 25px; text-align: center; background-color: #fff; display: inline-block; margin-right: 6px;';   
                $wrap_img = 'margin: 30px 0 25px; text-align: center;';
                $img = 'display: inline-block; max-width: 100%; height: auto; vertical-align: middle;'; 
                $note = 'text-align: right; color: #666; margin-top: 10px; font-size: 11px; line-height: 18px';
                $onMouseOver = "this.style.backgroundColor='#e73361'";
                $onMouseOut = "this.style.backgroundColor ='#d9d9d9'";
                $content = '<div style="'. $wrapper .'">';
                    $content .= '<div style="'. $header . '">';
                        $content .= '<a href="'.route('home').'" target="_blank" style="'. $logo .'"><img style="'.$img.'" src="'.asset('public/images/email_icon/banner-mail.png').'" alt="BiiGHoliday"></a>';
                    $content .= '</div> ';
                    $content .= '<div style="'. $container_fluid .'">'; 
                        $content .= '<div style="'. $about_box .'">';
                            $content .= '<ul style= "'. $about_box_ul .'">';
                                $content .= '<li style="'.  $about_box_info_li .'">'.$fullName.'</li>';
                                $content .= '<li style="color: #e62757; font-weight: bold;'. $about_box_info_li .' ">Greetings from BiiG Holiday !</li>';
                                $content .= '<li style="'.  $about_box_info_li .'">Many thanks for your interest.</li>';
                                $content .= '<li style="'.  $about_box_info_li .'">One of our travel consultants will contact you shortly to address <br/> your query.</li>';
                                $content .= '<li style="'.  $about_box_info_li .' margin-bottom:0;">In the meantime. you can review your message as detailed below.</li>';
                            $content .= '</ul>';
                            $content .= '<ul style="'. $about_box_ul . $list_button .'">';
                                $content .= '<li style="'. $list_button_li .'"><a href="'.route('home').'" style="'. $list_button_li_a .'" onMouseOver="'. $onMouseOver .'" onMouseOut="'. $onMouseOut .'">Send another request</a></li>';
                                $content .= '<li style="'. $list_button_li_right .'"><a href="'.route('home').'" style="'. $list_button_li_a_right .'" onMouseOver="'. $onMouseOver .'" onMouseOut="'. $onMouseOut .'">View all tours</a></li>';
                            $content .= '</ul>';
                        $content .= '</div>';
                    $content .= '</div>';
                    $content .= '<div style="'. $wrap_img .'">';
                        $content .= '<img src="'.asset('public/images/email_icon/base_fill_mail.png').'" alt="bee" style="'. $img .'" />';
                    $content .= '</div>';
                    $content .= '<div style="margin-bottom: 50px">';
                        $content .= '<div>';
                            $content .= '<h3 style="'. $h3 .'">Your personal information</h3>';
                            $content .= '<div style="'. $box_modal .'">';
                                $content .= '<ul style="'. $box_modal_ul .'">';
                                    $content .= '<li style="'. $box_modal_p_li .'">Name: <span style="'. $red_color .'"> '.$fullName.' </span></li>';
                                    //$content .= '<li style="'. $box_modal_p_li .'">Age Group: <span style="'. $red_color .'">'.$ageGroup.'</span></li>';
                                    $content .= '<li style="'. $box_modal_p_li .'">Phone number: <span style="'. $red_color .'"> '.$phone.' </span></li>';
                                    $content .= '<li style="'. $box_modal_p_li .'">Email: <a href="'.$email.'" target="_blank" style="'. $red_color .'">'.$email.'</a></li>';
                                    //$content .= '<li style="'. $box_modal_p_li .'">Country: <span style="'. $red_color .'">'.$country.'</span></li>';
                                    $content .= '<li style="'. $box_modal_p_li .'">Newsletter: <span style="'. $red_color .'">'. $newsletter .'</span></li>';
                                $content .= '</ul>';
                            $content .= '</div>';
                        $content .= '</div>';
                        $content .= '<div>';
                            $content .= '<h3 style="'. $h3 .'">Your Message</h3>';
                            $content .= '<div style="'. $box_modal .'">';
                                $content .= '<ul style="'. $box_modal_ul  .'">';
                                    $content .= '<li style="'. $box_modal_p_li .'">Subject: <span style="'. $red_color .'">'.$subject.'</span></li>';
                                    $content .= '<li style="'. $box_modal_p_li .'"><span style="color: #666">Message: </span> <p style="'. $red_color .'">'.$message.'</p></li>';
                                $content .= '</ul>';
                            $content .='</div>';
                        $content .= '</div>';
                        // if($firstNameIntro != "" || $lastNameIntro != "" || $titleIntro != ""){
                        //     $content .= '<div>';
                        //         $content .= '<h3 style="'. $h3 .'">Sponsorship</h3>';
                        //         $content .= '<div  style="'. $box_modal .'">';
                        //             $content .= '<ul style="'. $box_modal_ul  .' padding-left: 17px;">';
                        //                 $content .= '<li style="'. $box_modal_p_li .'">Are you recommended by an existing BiiG Holiday customer?: <span style="'. $red_color .'">Yes</span></li>';
                        //                 if($firstNameIntro != "" && $lastNameIntro != "" && $titleIntro != "" ){
                        //                     $content .= '<li style="'. $box_modal_p_li .'">Sponsored by: <span style="'. $red_color .'">'. $titleIntro.$firstNameIntro .' '. $lastNameIntro .'</span></li>';
                        //                 }elseif($firstNameIntro != "" && $lastNameIntro == "" && $titleIntro != ""){
                        //                     $content .= '<li style="'. $box_modal_p_li .'">Sponsored by: <span style="'. $red_color .'">'. $titleIntro.$firstNameIntro .'</span></li>';
                        //                 }elseif($firstNameIntro == "" && $lastNameIntro != "" && $titleIntro != ""){
                        //                     $content .= '<li style="'. $box_modal_p_li .'">Sponsored by: <span style="'. $red_color .'">'. $titleIntro.$lastNameIntro .'</span></li>';
                        //                 }elseif($firstNameIntro == "" && $lastNameIntro != "" && $titleIntro == ""){
                        //                     $content .= '<li style="'. $box_modal_p_li .'">Sponsored by: <span style="'. $red_color .'">'. $firstNameIntro .' '. $lastNameIntro .'</span></li>';
                        //                 }
                        //             $content .= '</ul>';
                        //         $content .= '</div>';
                        //     $content .= '</div>';
                        // }else{
                        //     $content .= '<div>';
                        //         $content .= '<h3 style="'. $h3 .'">Sponsorship</h3>';
                        //         $content .= '<div  style="'. $box_modal .'">';
                        //             $content .= '<ul style="'. $box_modal_ul  .' padding-left: 17px;">';
                        //                 $content .= '<li style="'. $box_modal_p_li .'">Are you recommended by an existing BiiG Holiday customer?: <span style="'. $red_color .'">No</span></li>';
                        //             $content .= '</ul>';
                        //         $content .= '</div>';
                        //     $content .= '</div>';
                        // }
                    $content .='</div>';    
                    $content .= '<ul style="'. $about_box_ul . $list_button_2 .'">';
                        $content .= '<li style="'. $list_button_li .'"><a href="'.route('home').'" style="'. $list_button_li_a .'" onMouseOver="'. $onMouseOver .'" onMouseOut="'. $onMouseOut .'">Send another request</a></li>';
                        $content .= '<li style="'. $list_button_li_right .'"><a href="'.route('home').'" style="'. $list_button_li_a_right .'" onMouseOver="'. $onMouseOver .'" onMouseOut="'. $onMouseOut .'">View all tours</a></li>';
                    $content .= '</ul>';
                    $content .= '<div style="'. $share_box .'">';
                        $content .= '<h3 style="'. $share_h3 .'">Follow us on</h3>';
                        $content .= '<ul style="'. $about_box_ul . $share_ul .'">';
                            $content .= '<li style="'. $share_li .'">';
                                $content .= '<a href="https://instagram.com/" target="_blank" style="'. $share_li_a .'">';
                                    $content .= '<img src="'.asset('public/images/email_icon/instagram.png').'" alt="" style="'. $img . '" />';
                                $content .= '</a>';
                            $content .= '</li>';
                            $content .= '<li style="'. $share_li .'">';
                                $content .= '<a href="https://facebook.com/" target="_blank" style="'. $share_li_a .'">';
                                    $content .= '<img src="'.asset('public/images/email_icon/facebook.png').'" alt="" style="'. $img . '" />';
                                $content .= '</a>';
                            $content .= '</li>';
                            $content .= '<li style="'. $share_li .'">';
                                $content .= '<a href="https://twitter.com/" target="_blank" style="'. $share_li_a .'">';
                                    $content .= '<img src="'.asset('public/images/email_icon/twitter.png').'" alt="" style="'. $img .  '" />';
                                $content .= '</a>';
                            $content .= '</li>';
                            $content .= '<li style="'. $share_li .'">';
                                $content .= '<a href="https://youtube.com/ target="_blank" style="'. $share_li_a .'">';
                                    $content .= '<img src="'.asset('public/images/email_icon/youtube.png').'" alt="" style="'. $img . '" />';
                                $content .= '</a>';
                            $content .= '</li>';
                            $content .= '<li style="'. $share_li .'">';
                                $content .= '<a href="https://pinterest.com/" target="_blank" style="'. $share_li_a .'">';
                                    $content .= '<img src="'.asset('public/images/email_icon/pinterest.png').'" alt="" style="'. $img . '" />';
                                $content .= '</a>';
                            $content .= '</li>';
                        $content .= '</ul>';
                    $content .= '</div>';
                    $content .= '<div style="'. $footer .'">';
                        $content .= '<ul style="'. $about_box_ul . $footer_ul .'">';
                            $content .= '<li style="'. $footer_li .'">';
                                $content .= '<span style="'. $footer_span .'">';
                                    $content .= '<img src="'.asset('public/images/email_icon/phone.png').'" alt="" style="'. $img . '" />';
                                $content .= '</span>';
                                $content .= 'Hotline Laos *';
                                $content .= '<p><a href="tel:+856 20 9596 9226" style="'. $footer_li_a .'"><img src="'.asset('public/images/email_icon/laos-icon.png').'" alt="" style=" margin-right: 5px; '. $img . '" />+856 20 9596 9226</a></p>';
                            $content .= '</li>';
                            $content .= '<li style="'. $footer_li .'">';
                                $content .= '<span style="'. $footer_span .'">';
                                    $content .= '<img src="'.asset('public/images/email_icon/phone.png').'" alt="" style="'. $img . '" />';
                                $content .= '</span>';
                                $content .= 'Hotline Vietnam *';
                                $content .= '<p><a href="tel:+84 977 247 394" style="'. $footer_li_a .'"><img src="'.asset('public/images/email_icon/vietnam-icon.png').'" alt="" style=" margin-right: 5px; '. $img . '" />+84 977 247 394</a></p>';
                            $content .= '</li>';
                            $content .= '<li style="'. $footer_li .'">';
                                $content .= '<span style="'. $footer_span .'">';
                                    $content .= '<img src="'.asset('public/images/email_icon/envelope-small.png').'" alt="" style="'. $img .'" />';
                                $content .= '</span>';
                                $content .= 'Email';
                                $content .= '<p><a href="mailto:'.$mailSystem.'" style="'. $footer_li_a .'">'.$mailSystem.'</a></p>';
                            $content .= '</li>';
                            $content .= '<li style="'. $footer_li .'">';
                                $content .= '<span style="'. $footer_span .'">';
                                    $content .= '<img src="'.asset('public/images/email_icon/global.png').'" alt="" style="'. $img .'" />';
                                $content .= '</span>';
                                $content .= 'Website';
                                $content .= '<p><a href="'.route('home').'" style="'. $footer_li_a .'">'. $domain .'</a></p>';
                            $content .= '</li>';
                        $content .= '</ul>';
                    $content .= '</div>';
                    $content .= '<p style="clear:both;'. $note .'">* Call us free on whatsapp. Messenger. Skype</p>';
                $content .= '</div>';
                //mail admin
                // $data = array( 'email' => $email, 'from' => $mailSystem, 'fullName' => $fullName, 'content'=> $content);
                // Mail::send( 'mails.admin.contact', compact('data'), function( $message ) use ($data){
                //     $message->to($data['from'])
                //             ->from( $data['email'], $data['fullName'] )
                //             ->subject('[Contact to BiigHoliday] - '.$data['fullName']);
                // });
                $data = array( 'email' => $email, 'from' => '8085678@gmail.com', 'fullName' => $fullName, 'content'=> $content);
                Mail::send( 'mails.admin.contact', compact('data'), function( $message ) use ($data){
                    $message->to($data['from'])
                            ->from( $data['email'], '[Sonasia Holiday]' )
                            ->subject('[Contact to BiigHoliday] - '.$data['fullName']);
                });
                //mail customer
                $data = array( 'email' => $email, 'from' => $email, 'fullName' => $fullName, 'content' => $content);
                Mail::send( 'mails.contact', compact('data'), function( $message ) use ($data){
                    $message->to($data['email'])
                            ->from( $data['from'], '[Sonasia Holiday]')
                            ->subject('[Biig] Thank you sent request');
                });
            endif;
        endif;
    }
     /*
    * Send mail setup cal phone by ajax
    */
    public function updateSetupCallPhone(Request $request){
        // $alert = "error";
        if($request->ajax()):
            $fullName = $request->title.$request->firstName.' '.$request->lastName;
            $email = $request->email;
            $ageGroup = $request->ageGroup;
            $country = $request->country;
            $newsletter = $request->newsletter;
            $phone = $request->areaCode.$request->numberPhone;
            $subject = $request->subject;
            $titleIntro = $request->titleIntro;
            $firstNameIntro = $request->firstNameIntro;
            $lastNameIntro = $request->lastNameIntro;
            $appointmentDate = $request->appointmentDate;
            $timeZone = $request->timeZone;
            $timeSlots = $request->timeSlot;
            $mobileApps = $request->mobileApp;
            $mapp;
            $checkMobileApps = false;
            if($mobileApps != ""){
                $checkMobileApps = true;
                $mobileApps = (array) json_decode($mobileApps);
            }
            if($checkMobileApps == false) : $mapp = "";
            else :
                $i = 0; $arrMobileApp;
                foreach($mobileApps as $mobileApp) :
                $title = $mobileApp[0];
                $value = $mobileApp[1];
                    if($i == 0) : 
                        $arrMobileApp = $title.' : '.$value;
                    elseif($i > 0) : 
                        $arrMobileApp .= ', ' .$title.' : '.$value;
                    endif;
                    $i++;
                endforeach;
                $mapp = $arrMobileApp;
            endif;
            $ts;
            $checkTimeSlots = false;
            if($timeSlots != "") :
                $checkTimeSlots = true;
                $timeSlots = (array) json_decode($timeSlots);
            endif;
            if($checkTimeSlots == false) : $ts = ""; 
            else : 
                $i = 0; $arrTimeSlot;
                foreach($timeSlots as $timeSlot) : 
                    if($i == 0) : 
                        $arrTimeSlot = $timeSlot;
                    elseif($i > 0) : 
                        $arrTimeSlot .= ', '.$timeSlot;
                    endif;
                    $i++;
                endforeach;
                $ts = $arrTimeSlot;
            endif;
            $phoneSystem = phone();
            $mailSystem = mailSystem();
            $domain = $request->getHost();
            // content 
            if(!empty($fullName) && !empty($email) && !empty($ageGroup) && !empty($country) && !empty($phone) && !empty($subject) && !empty($timeZone) && !empty($appointmentDate)) : 
                $h3 = 'font-size: 16px;line-height:31px;background-color:#666;border-radius: 10px; margin: 0;color: #fff;text-align: center; ';
                $fleft = 'float: left; width: 100%;';
                $overflow = 'overflow: hidden';
                $wrapper = 'font-size: 15px; line-height: 21px; color: #666; font-family: Arial; background-color: #fff; width: 600px; margin: 0 auto; -webkit-overflow-scrolling: touch; overflow: auto;';
                $header = 'width: 100%;';
                $logo ='display: block';
                $container_fluid = 'padding: 0 40px;';
                $box_modal = 'padding: 10px; text-align: left; columns: 2';
                $box_modal_ul = 'padding-left: 25px; margin: 0;';
                $box_modal_p_li = 'color: #555; position: relative; margin-left: 0;';
                $about_box = 'background-color: #f1f1f1;padding:18px 34px 44px; text-align: center; border-bottom-right-radius: 10px; border-bottom-left-radius: 10px;';
                $about_box_ul = 'padding-left:0 ;list-style: none; margin: 0; color: #7e7e7e;';
                $about_box_info_li = 'margin-bottom: 22px; display: block; margin-left: 0;';
                $list_button = 'margin-top: 25px;';
                $list_button_2 = 'margin-bottom: 25px; background-color:#f1f1f1; padding: 20px 0; border-radius:10px;';
                $list_button_li = 'text-align: center;  margin: 0 0 15px 0;';
                $list_button_li_right = 'text-align: center; margin: 0 ;';
                $list_button_li_a = 'display: block; width: 300px; max-width: 100%; line-height: 33px; background-color: #e73361;color: #fff; border-radius: 10px; text-decoration: none; margin: 0 auto;';
                $list_button_li_a_right = 'display: block; width: 300px; max-width: 100%; line-height: 33px;background-color: #34e6d0;color: #fff; border-radius: 10px; text-decoration: none;  margin: 0 auto;';
                $red_color = 'color: #e73362';
                $button_group = 'background-color: #f1f1f1; margin-bottom: 50px; border-radius: 10px;';
                $share_box = 'background-color: #f1f1f1; border-top-left-radius: 10px; border-top-right-radius: 10px;';
                $share_h3 = 'color: #666; font-size: 14px; line-height: 20px; margin: 19px 0 25px; text-align: center;';
                $share_ul = 'overflow: hidden;';
                $share_li = 'float:left; width: 20%; max-width: 100%; max-height: 100%; margin: 0  auto; box-sizing: border-box; margin-bottom: 15px;';
                $share_li_a = 'width: 30px; height: 30px; line-height: 30px; text-align: center; max-width: 100%; margin: 0 auto; background-color: #e73361; border-radius: 5px; display: block;';
                $footer = 'background-color: #666; clear: both;';
                $footer_ul = 'overflow:hidden; padding: 20px 0;';
                $footer_li = 'width: 33.33%; float: left; color: #fff; max-width: 100%; max-height: 100%; margin: 0  auto; box-sizing: border-box; text-align: center;';
                $footer_li_a = 'color: inherit; text-decoration: underline; font-size: 14px;';
                $footer_span = 'border-radius: 50%; width: 25px; height: 25px; line-height: 25px; text-align: center; background-color: #fff; display: inline-block; margin-right: 6px;';   
                $wrap_img = 'margin: 30px 0 25px; text-align: center;';
                $img = 'display: inline-block; max-width: 100%; height: auto; vertical-align: middle;'; 
                $note = 'text-align: right; color: #666; margin-top: 10px; font-size: 11px; line-height: 18px';
                $onMouseOver = "this.style.backgroundColor='#e73361'";
                $onMouseOut = "this.style.backgroundColor ='#d9d9d9'";
                $content = '<div style="'. $wrapper .'">';
                    $content .= '<div style="'. $header . $fleft. '">';
                        $content .= '<a href="'.route('home').'" target="_blank" style="'. $logo .'"><img style="'.$img.'" src="'.asset('public/images/email_icon/banner-mail.png').'" alt="BiiGHoliday"></a>';
                    $content .= '</div> ';
                    $content .= '<div style="'. $container_fluid .'">'; 
                        $content .= '<div style="'. $about_box .'">';
                            $content .= '<ul style= "'. $about_box_ul .'">';
                                $content .= '<li style="'.  $about_box_info_li .'">'.$fullName.'</li>';
                                $content .= '<li style="color: #e62757; font-weight: bold;'. $about_box_info_li .' ">Greetings from BiiG Holiday !</li>';
                                $content .= '<li style="'.  $about_box_info_li .'">Many thanks for your interest.</li>';
                                $content .= '<li style="'.  $about_box_info_li .'">One of our travel consultants will contact you shortly to address <br/> your query.</li>';
                                $content .= '<li style="'.  $about_box_info_li .' margin-bottom:0;">In the meantime. you can review your message as detailed below.</li>';
                            $content .= '</ul>';
                            $content .= '<ul style="'. $about_box_ul . $list_button .'">';
                                $content .= '<li style="'. $list_button_li .'"><a href="'.route('home').'" style="'. $list_button_li_a .'" onMouseOver="'. $onMouseOver .'" onMouseOut="'. $onMouseOut .'">Send another request</a></li>';
                                $content .= '<li style="'. $list_button_li_right .'"><a href="'.route('home').'" style="'. $list_button_li_a_right .'" onMouseOver="'. $onMouseOver .'" onMouseOut="'. $onMouseOut .'">View all tours</a></li>';
                            $content .= '</ul>';
                        $content .= '</div>';
                    $content .= '</div>';
                    $content .= '<div style="'. $wrap_img .'">';
                        $content .= '<img src="'.asset('public/images/email_icon/base_fill_mail.png').'" alt="bee" style="'. $img .'" />';
                    $content .= '</div>';
                    $content .= '<div style="margin-bottom: 50px">';
                        $content .= '<>';
                            $content .= '<h3 style="'. $h3 .'">Your personal information</h3>';
                            $content .= '<div style="'. $box_modal .'">';
                                $content .= '<ul style="'. $box_modal_ul .'">';
                                    $content .= '<li style="'. $box_modal_p_li .'">Name: <span style="'. $red_color .'"> '.$fullName.' </span></li>';
                                    $content .= '<li style="'. $box_modal_p_li .'">Age Group: <span style="'. $red_color .'"> '.$ageGroup.' </span></li>';
                                    $content .= '<li style="'. $box_modal_p_li .'">Phone number: <span style="'. $red_color .'"> '.$phone.' </span></li>';
                                    $content .= '<li style="'. $box_modal_p_li .'">Email: <a href="'.$email.'" target="_blank" style="'. $red_color .'"> '.$email.' </a></li>';
                                    $content .= '<li style="'. $box_modal_p_li .'">Country: <span style="'. $red_color .'"> '.$country.' </span></li>';
                                    $content .= '<li style="'. $box_modal_p_li .'">Newsletter: <span style="'. $red_color .'"> '.$newsletter.' </span></li>';
                                $content .= '</ul>';
                            $content .= '</div>';
                        $content .= '</div>';
                        $content .= '<div>';
                            $content .= '<h3 style="'. $h3 .'">Set up a phone call</h3>';
                            $content .= '<div style="'. $box_modal .'">';
                                $content .= '<ul style="'. $box_modal_ul  .'">';
                                    $content .= '<li style="'. $box_modal_p_li .'">Preferred channel to reach you : <span style="'. $red_color .'">'. $mapp .'</span></li>';
                                    $content .= '<li style="'. $box_modal_p_li .'">Appointment date : <span style="'. $red_color .'">'.$appointmentDate.'</span></li>';
                                    $content .= '<li style="'. $box_modal_p_li .'">Appointment time slot : <span style="'. $red_color .'">'.$ts.'</span></li>';
                                    $content .= '<li style="'. $box_modal_p_li .'">Appointment time zone : <span style="'. $red_color .'">'.$timeZone.'</span></li>';
                                    $content .= '<li style="'. $box_modal_p_li .'">Subject: <span style="'. $red_color .'">'.$subject.'</span></li>';
                                $content .= '</ul>';
                            $content .='</div>';
                        $content .= '</div>';
                        if($firstNameIntro != "" || $lastNameIntro != "" || $titleIntro != ""){
                            $content .= '<div>';
                                $content .= '<h3 style="'. $h3 .'">Sponsorship</h3>';
                                $content .= '<div  style="'. $box_modal .'">';
                                    $content .= '<ul style="'. $box_modal_ul  .' padding-left: 17px;">';
                                        $content .= '<li style="'. $box_modal_p_li .'">Are you recommended by an existing BiiG Holiday customer? : <span style="'. $red_color .'">Yes</span></li>';
                                        if($firstNameIntro != "" && $lastNameIntro != "" && $titleIntro != ""){
                                            $content .= '<li style="'. $box_modal_p_li .'">Sponsored by: <span style="'. $red_color .'">'. $titleIntro.$firstNameIntro .' '. $lastNameIntro .'</span></li>';
                                        }elseif($firstNameIntro != "" && $lastNameIntro == "" && $titleIntro != ""){
                                            $content .= '<li style="'. $box_modal_p_li .'">Sponsored by: <span style="'. $red_color .'">'. $titleIntro.$firstNameIntro .'</span></li>';
                                        }elseif($firstNameIntro == "" && $lastNameIntro != "" && $titleIntro != ""){
                                            $content .= '<li style="'. $box_modal_p_li .'">Sponsored by: <span style="'. $red_color .'">'. $titleIntro.$lastNameIntro .'</span></li>';
                                        }
                                    $content .= '</ul>';
                                $content .= '</div>';
                            $content .= '</div>';
                        }else{
                            $content .= '<div>';
                                $content .= '<h3 style="'. $h3 .'">Sponsorship</h3>';
                                $content .= '<div  style="'. $box_modal .'">';
                                    $content .= '<ul style="'. $box_modal_ul  .' padding-left: 17px;">';
                                        $content .= '<li style="'. $box_modal_p_li .'">Are you recommended by an existing BiiG Holiday customer? : <span style="'. $red_color .'">No</span></li>';
                                    $content .= '</ul>';
                                $content .= '</div>';
                            $content .= '</div>';
                        }
                    $content .='</div>';   
                    $content .= '<ul style="'. $about_box_ul . $list_button_2 .'">';
                        $content .= '<li style="'. $list_button_li .'"><a href="'.route('home').'" style="'. $list_button_li_a .'" onMouseOver="'. $onMouseOver .'" onMouseOut="'. $onMouseOut .'">Send another request</a></li>';
                        $content .= '<li style="'. $list_button_li_right .'"><a href="'.route('home').'" style="'. $list_button_li_a_right .'" onMouseOver="'. $onMouseOver .'" onMouseOut="'. $onMouseOut .'">View all tours</a></li>';
                    $content .= '</ul>';
                    $content .= '<div style="'. $share_box .'">';
                        $content .= '<h3 style="'. $share_h3 .'">Follow us on</h3>';
                        $content .= '<ul style="'. $about_box_ul . $share_ul .'">';
                            $content .= '<li style="'. $share_li .'">';
                                $content .= '<a href="https://instagram.com/" target="_blank" style="'. $share_li_a .'">';
                                    $content .= '<img src="'.asset('public/images/email_icon/instagram.png').'" alt="" style="'. $img . '" />';
                                $content .= '</a>';
                            $content .= '</li>';
                            $content .= '<li style="'. $share_li .'">';
                                $content .= '<a href="https://facebook.com/" target="_blank" style="'. $share_li_a .'">';
                                    $content .= '<img src="'.asset('public/images/email_icon/facebook.png').'" alt="" style="'. $img . '" />';
                                $content .= '</a>';
                            $content .= '</li>';
                            $content .= '<li style="'. $share_li .'">';
                                $content .= '<a href="https://twitter.com/" target="_blank" style="'. $share_li_a .'">';
                                    $content .= '<img src="'.asset('public/images/email_icon/twitter.png').'" alt="" style="'. $img .  '" />';
                                $content .= '</a>';
                            $content .= '</li>';
                            $content .= '<li style="'. $share_li .'">';
                                $content .= '<a href="https://youtube.com/ target="_blank" style="'. $share_li_a .'">';
                                    $content .= '<img src="'.asset('public/images/email_icon/youtube.png').'" alt="" style="'. $img . '" />';
                                $content .= '</a>';
                            $content .= '</li>';
                            $content .= '<li style="'. $share_li .'">';
                                $content .= '<a href="https://pinterest.com/" target="_blank" style="'. $share_li_a .'">';
                                    $content .= '<img src="'.asset('public/images/email_icon/pinterest.png').'" alt="" style="'. $img . '" />';
                                $content .= '</a>';
                            $content .= '</li>';
                        $content .= '</ul>';
                    $content .= '</div>';
                    $content .= '<div style="'. $footer .'">';
                    $content .= '<ul style="'. $about_box_ul . $footer_ul .'">';
                        $content .= '<li style="'. $footer_li .'">';
                            $content .= '<span style="'. $footer_span .'">';
                                $content .= '<img src="'.asset('public/images/email_icon/phone.png').'" alt="" style="'. $img . '" />';
                            $content .= '</span>';
                            $content .= 'Hotline Laos *';
                            $content .= '<p><a href="tel:+856 20 9596 9226" style="'. $footer_li_a .'"><img src="'.asset('public/images/email_icon/laos-icon.png').'" alt="" style=" margin-right: 5px; '. $img . '" />+856 20 9596 9226</a></p>';
                        $content .= '</li>';
                        $content .= '<li style="'. $footer_li .'">';
                            $content .= '<span style="'. $footer_span .'">';
                                $content .= '<img src="'.asset('public/images/email_icon/phone.png').'" alt="" style="'. $img . '" />';
                            $content .= '</span>';
                            $content .= 'Hotline Vietnam *';
                            $content .= '<p><a href="tel:+84 977 247 394" style="'. $footer_li_a .'"><img src="'.asset('public/images/email_icon/vietnam-icon.png').'" alt="" style=" margin-right: 5px; '. $img . '" />+84 977 247 394</a></p>';
                        $content .= '</li>';
                        $content .= '<li style="'. $footer_li .'">';
                            $content .= '<span style="'. $footer_span .'">';
                                $content .= '<img src="'.asset('public/images/email_icon/envelope-small.png').'" alt="" style="'. $img .'" />';
                            $content .= '</span>';
                            $content .= 'Email';
                            $content .= '<p><a href="mailto:'.$mailSystem.'" style="'. $footer_li_a .'">'.$mailSystem.'</a></p>';
                        $content .= '</li>';
                        $content .= '<li style="'. $footer_li .'">';
                            $content .= '<span style="'. $footer_span .'">';
                                $content .= '<img src="'.asset('public/images/email_icon/global.png').'" alt="" style="'. $img .'" />';
                            $content .= '</span>';
                            $content .= 'Website';
                            $content .= '<p><a href="'.route('home').'" style="'. $footer_li_a .'">'. $domain .'</a></p>';
                        $content .= '</li>';
                    $content .= '</ul>';
                $content .= '</div>';
                    $content .= '<p style=" clear:both; '. $note .'">* Call us free on whatsapp. Messenger. Skype</p>';
                $content .= '</div>';
                //mail admin
                // $data = array( 'email' => $email, 'from' => $mailSystem, 'fullName' => $fullName, 'content'=> $content);
                // Mail::send( 'mails.admin.contact', compact('data'), function( $message ) use ($data){
                //     $message->to($data['from'])
                //             ->from( $data['email'], $data['fullName'] )
                //             ->subject('[Contact to BiigHoliday] - '.$data['fullName']);
                // });
                $data = array( 'email' => $email, 'from' => '8085678@gmail.com', 'fullName' => $fullName, 'content'=> $content);
                Mail::send( 'mails.admin.setup_phone_call', compact('data'), function( $message ) use ($data){
                    $message->to($data['from'])
                            ->from( $data['email'], $data['fullName'] )
                            ->subject('[Contact to BiigHoliday] - '.$data['fullName']);
                });
                //mail customer
                $data = array( 'email' => $email, 'from' => $email, 'fullName' => $fullName, 'content' => $content);
                Mail::send( 'mails.setup_phone_call', compact('data'), function( $message ) use ($data){
                    $message->to($data['email'])
                            ->from( $data['from'], $data['fullName'] )
                            ->subject('[Biig] Thank you sent request');
                });
                // $alert = 'Thank you sent request to the BiigHoliday, we will reeback you in the early time.';
            endif;
        endif;
        // return $alert;
    }
    /*
    * Send mail create my trip by ajax
    */
    public function updateCreateMyTrip(Request $request){
        // $alert = "error";
        if($request->ajax()):
            $fullName = $request->title.$request->fullName;
            $phone = $request->numberPhone;
            //$country = $request->country;
            $email = $request->email;
            $ageGroup = $request->ageGroup;
            $newsletter = $request->newsletter;
            $condition = $request->condition;
            $numAdult = $request->numAdult;
            $numChild = $request->numChild;
            $numBaby = $request->numBaby;
            $numTeenager = $request->numTeenager;
            $arrivalDate = $request->arrivalDate;
            $duration = $request->duration;
            $explainTrip = $request->explainTrip;
            $otherDest = $request->otherDest;
            $budgetPerson =  $request->budgetPerson;
            $currencyPerson = $request->currencyPerson;
            $accommodation = $request->accommodation;
            $accommon = $request->accommon;
            $physical = $request->physical;
            $project = $request->project;
            //$furtherNote =  $request->furtherNote;
            $meals= $request->meals;
            $mealsTrips = $request->mealsTrips;
            $doubleRoom = $request->doubleRoom;
            $twinRoom = $request->twinRoom;
            $individualRoom = $request->individualRoom;
            $tripleRoom = $request->tripleRoom;
            $rooms = "";
            if(intval($doubleRoom) > 0){
                if( $rooms == ""){
                    $rooms .= $doubleRoom." double room ";
                }else{
                    $rooms .= ", ".$doubleRoom." double rooms ";
                }
            }
            if(intval($twinRoom) > 0){
                if( $rooms == ""){
                    $rooms .= $twinRoom. " twin rooms";
                }else{
                    $rooms .=", ".$twinRoom. " twin rooms";
                }
            }
            if(intval($individualRoom) > 0){
                if( $rooms == ""){
                    $rooms .= $individualRoom." individual room";
                }else{
                    $rooms .= ", ".$individualRoom." individual room";
                }
            }
            if(intval($tripleRoom) > 0){
                if( $rooms == ""){
                    $rooms .= $tripleRoom." triple rooms ";
                }else{
                    $rooms .=", ".$tripleRoom." triple rooms ";
                }
            }
            $destinations = $request->destination;
            $tourTypes = $request->tourType;
            //$hobbies = $request->hobbies;
            //$lastLong = $request->lastLong;
            $canContact = $request->canContact;
            $titleIntro = $request->titleIntro;
            $fullNameIntro = $request->fullNameIntro;
           /* $checkMobileApps = false;
            $appointmentDate = $request->appointmentDate;
            $timeZone = $request->timeZone;
            $timeSlots = $request->timeSlot;
            $mobileApps = $request->mobileApp;  
            $checkMobileApps = false;
            if($mobileApps != ""){
                $checkMobileApps = true;
                $mobileApps = (array) json_decode($mobileApps);
            }
            $mapp;
            if($checkMobileApps == false) : $mapp = "";
            else :
                $i = 0; $arrMobileApp;
                foreach($mobileApps as $mobileApp) :
                $title = $mobileApp[0];
                $value = $mobileApp[1];
                    if($i == 0) : 
                        $arrMobileApp = $title.' : '.$value;
                    elseif($i > 0) : 
                        $arrMobileApp .= ', ' .$title.' : '.$value;
                    endif;
                    $i++;
                endforeach;
                $mapp = $arrMobileApp;
            endif;*/
           /* $checkTimeSlots = false;
            if($timeSlots != "") :
                $checkTimeSlots = true;
                $timeSlots = (array) json_decode($timeSlots);
            endif;
            $ts;
            if($checkTimeSlots == false) : $ts = ""; 
            else : 
                $i = 0; $arrTimeSlot;
                foreach($timeSlots as $timeSlot) : 
                    if($i == 0) : 
                        $arrTimeSlot = $timeSlot;
                    elseif($i > 0) : 
                        $arrTimeSlot .= ', '.$timeSlot;
                    endif;
                    $i++;
                endforeach;
                $ts = $arrTimeSlot;
            endif;*/
            $checkDestinations = false;
            if($destinations != "") :
                $checkDestinations = true;
                $destinations = (array) json_decode($destinations);
            endif;
            $desc; $descTitle;
            if($checkDestinations == true) : 
                $i = 0; $arrDestination; $arrDestinationTitle;
                foreach($destinations as $destination) : 
                    if($i == 0) : 
                        $arrDestination = $destination;
                        $arrDestinationTitle =  $destination;
                    elseif($i > 0) : 
                        $arrDestination .= ', '.$destination;
                        $arrDestinationTitle .=  ' + ' .$destination;
                    endif;
                    $i++;
                endforeach;
                $desc = $arrDestination;
                $descTitle = $arrDestinationTitle;
            endif;
            $checkTourTypes = false;
            if($tourTypes != ""): 
                //$checkMobileApps = true;
                $tourTypes = (array) json_decode($tourTypes);
            endif;
            $tour;
            if($checkTourTypes == false) : $tour = "";
            else :
                $i = 0; $arrtourType;
                foreach($tourTypes as $tourType) :
                    if($i == 0) : 
                        $arrtourType = $tourType;
                    elseif($i > 0) : 
                        $arrtourType .= ', ' .$tourType;
                    endif;
                    $i++;
                endforeach;
                $tour = $arrtourType;
            endif;
            $phoneSystem = phone();
            $mailSystem = mailSystem();
            $domain = $request->getHost();
            $splitDate = explode(',',$arrivalDate);
            $replaceDate = str_replace('/', '-', $splitDate[1]);
            $dateTitle = date("d M Y", strtotime($replaceDate));
            // content
            if(!empty($fullName) && !empty($email) && !empty($ageGroup) && !empty($phone) && !empty($arrivalDate) && intval($numAdult) > 0 && !empty($desc) && !empty($condition)) : 
                $h3 = 'font-size: 16px;line-height:31px;background-color:#666;border-radius: 10px; margin: 0;color: #fff;text-align: center; ';
                $fleft = 'float: left; width: 100%;';
                $overflow = 'overflow: hidden';
                $wrapper = 'font-size: 15px; line-height: 21px; color: #666; font-family: Arial; background-color: #fff; width: 600px; margin: 0 auto; -webkit-overflow-scrolling: touch; overflow: auto;';
                $header = 'width: 100%;';
                $logo ='display: block';
                $container_fluid = 'padding: 0 40px; clear: both;';
                $box_modal = 'padding: 10px; text-align: left;';
                $box_modal_ul = 'padding-left: 25px; margin: 0;';
                $box_modal_p_li = 'color: #555; position: relative; margin-left: 0;';
                $about_box = 'background-color: #f1f1f1;padding:18px 34px 44px; text-align: center; border-bottom-right-radius: 10px; border-bottom-left-radius: 10px;';
                $about_box_ul = 'padding-left:0 ;list-style: none; margin: 0; color: #7e7e7e;';
                $about_box_info_li = 'margin-bottom: 22px; display: block; margin-left: 0;';
                $list_button = 'margin-top: 25px;';
                $list_button_2 = 'margin-bottom: 25px; background-color:#f1f1f1; padding: 20px 0; border-radius:10px;';
                $list_button_li = 'text-align: center;  margin: 0 0 15px 0;';
                $list_button_li_right = 'text-align: center; margin: 0 ;';
                $list_button_li_a = 'display: block; width: 300px; max-width: 100%; line-height: 33px; background-color: #e73361;color: #fff; border-radius: 10px; text-decoration: none; margin: 0 auto;';
                $list_button_li_a_right = 'display: block; width: 300px; max-width: 100%; line-height: 33px;background-color: #34e6d0;color: #fff; border-radius: 10px; text-decoration: none;  margin: 0 auto;';
                $red_color = 'color: #e73362';
                $button_group = 'background-color: #f1f1f1; margin-bottom: 50px; border-radius: 10px;';
                $share_box = 'background-color: #f1f1f1; border-top-left-radius: 10px; border-top-right-radius: 10px;';
                $share_h3 = 'color: #666; font-size: 14px; line-height: 20px; margin: 19px 0 25px; text-align: center;';
                $share_ul = 'overflow: hidden;';
                $share_li = 'float:left; width: 20%; max-width: 100%; max-height: 100%; margin: 0  auto; box-sizing: border-box; margin-bottom: 15px;';
                $share_li_a = 'width: 30px; height: 30px; line-height: 30px; text-align: center; max-width: 100%; margin: 0 auto; background-color: #e73361; border-radius: 5px; display: block;';
                $footer = 'background-color: #666; clear: both;';
                $footer_ul = 'overflow:hidden; padding: 20px 0;';
                $footer_li = 'width: 33.33%; float: left; color: #fff; max-width: 100%; max-height: 100%; margin: 0  auto; box-sizing: border-box; text-align: center;';
                $footer_li_a = 'color: inherit; text-decoration: underline; font-size: 14px;';
                $footer_span = 'border-radius: 50%; width: 25px; height: 25px; line-height: 25px; text-align: center; background-color: #fff; display: inline-block; margin-right: 6px;';   
                $wrap_img = 'margin: 30px 0 25px; text-align: center;';
                $img = 'display: inline-block; max-width: 100%; height: auto; vertical-align: middle;'; 
                $note = 'text-align: right; color: #666; margin-top: 10px; font-size: 11px; line-height: 18px';
                $onMouseOver = "this.style.backgroundColor='#e73361'";
                $onMouseOut = "this.style.backgroundColor ='#d9d9d9'";
                $content = '<div style="'. $wrapper .'">';
                    $content .= '<div style="'. $header . $fleft. '">';
                        $content .= '<a href="'.route('home').'" target="_blank" style="'. $logo .'"><img style="'.$img.'" src="'.asset('public/images/email_icon/banner-mail.png').'" alt="BiiGHoliday"></a>';
                    $content .= '</div> ';
                    $content .= '<div style="'. $container_fluid .'">'; 
                        $content .= '<div style="'. $about_box .'">';
                            $content .= '<ul style= "'. $about_box_ul .'">';
                                $content .= '<li style="'.  $about_box_info_li .'">'.$fullName.'</li>';
                                $content .= '<li style="color: #e62757; font-weight: bold;'. $about_box_info_li .' ">Greetings from BiiG Holiday !</li>';
                                $content .= '<li style="'.  $about_box_info_li .'">Many thanks for your interest.</li>';
                                $content .= '<li style="'.  $about_box_info_li .'">One of our travel consultants will contact you shortly to address <br/> your query.</li>';
                                $content .= '<li style="'.  $about_box_info_li .' margin-bottom:0;">In the meantime. you can review your message as detailed below.</li>';
                            $content .= '</ul>';
                            $content .= '<ul style="'. $about_box_ul . $list_button .'">';
                                $content .= '<li style="'. $list_button_li .'"><a href="'.route('home').'" style="'. $list_button_li_a .'" onMouseOver="'. $onMouseOver .'" onMouseOut="'. $onMouseOut .'">Send another request</a></li>';
                                $content .= '<li style="'. $list_button_li_right .'"><a href="'.route('home').'" style="'. $list_button_li_a_right .'" onMouseOver="'. $onMouseOver .'" onMouseOut="'. $onMouseOut .'">View all tours</a></li>';
                            $content .= '</ul>';
                        $content .= '</div>';
                    $content .= '</div>';
                    $content .= '<div style="'. $wrap_img .'">';
                        $content .= '<img src="'.asset('public/images/email_icon/base_fill_mail.png').'" alt="bee" style="'. $img .'" />';
                    $content .= '</div>';
                    $content .= '<div style="margin-bottom: 50px;">';
                        $content .= '<div>';
                            $content .= '<h3 style="'. $h3 .'">Your personal information</h3>';
                            $content .= '<div style="'. $box_modal .'">';
                                $content .= '<ul style="'. $box_modal_ul .'">';
                                    $content .= '<li style="'. $box_modal_p_li .'">Name: <span style="'. $red_color .'"> '.$fullName.' </span></li>';
                                    $content .= '<li style="'. $box_modal_p_li .'">Age Group: <span style="'. $red_color .'"> '.$ageGroup.' </span></li>';
                                    $content .= '<li style="'. $box_modal_p_li .'">Phone number: <span style="'. $red_color .'"> '.$phone.' </span></li>';
                                    $content .= '<li style="'. $box_modal_p_li .'">Email: <a href="'.$email.'" target="_blank" style="'. $red_color .'"> '.$email.' </a></li>';
                                    if(intval($numChild) > 0 || intval($numBaby) > 0){
                                        if(intval($numChild) > 0 && intval($numBaby) == 0){
                                             $content .= '<li style="'. $box_modal_p_li .'">Number of Travelers: <span style="'. $red_color .'"> Adult: '.$numAdult.' , Child 2-12 y.o: '.$numChild.'  </span></li>';
                                        }elseif(intval($numChild) == 0 && intval($numBaby) > 0){
                                             $content .= '<li style="'. $box_modal_p_li .'">Number of Travelers: <span style="'. $red_color .'"> Adult: '.$numAdult.' , Baby < 2 y.o: '.$numBaby.'  </span></li>';
                                        }else{
                                             $content .= '<li style="'. $box_modal_p_li .'">Number of Travelers: <span style="'. $red_color .'"> Adult: '.$numAdult.' , Child 2-12 y.o: '.$numChild.' / Baby < 2 y.o: '.$numBaby.'  </span></li>';
                                        }
                                     }else{
                                         $content .= '<li style="'. $box_modal_p_li .'">Number of Travelers: <span style="'. $red_color .'"> Adult: '.$numAdult.' </span></li>';
                                    }
                                    $content .= '<li style="'. $box_modal_p_li .'">Physical conditions of participants: <span style="'. $red_color .'"> '.$condition.' </span></li>';
                                    $content .= '<li style="'. $box_modal_p_li .'">Newsletter: <span style="'. $red_color .'"> '.$newsletter.' </span></li>';
                                $content .= '</ul>';
                            $content .= '</div>';
                        $content .= '</div>';
                        $content .= '<div>';
                            $content .= '<h3 style="'. $h3 .'">Your project information</h3>';
                            $content .= '<div style="'. $box_modal .'">';
                                $content .= '<ul style="'. $box_modal_ul .'">';
                                    $content .= '<li style="'. $box_modal_p_li .'">Arrival date : <span style="'. $red_color .'">'. $arrivalDate .'</span></li>';
                                    $content .= '<li style="'. $box_modal_p_li .'">Duration : <span style="'. $red_color .'">'.$duration.'days</span></li>';
                                    $content .= '<li style="'. $box_modal_p_li .'">Budget per person : <span style="'. $red_color .'">'.$budgetPerson.' '.$currencyPerson.'</span></li>';
                                    $content .= '<li style="'. $box_modal_p_li .'">Accommodation type : <span style="'. $red_color .'">'.$accommodation.'</span></li>';
                                    $content .= '<li style="'. $box_modal_p_li .'">Number of rooms : <span style="'. $red_color .'">'.$rooms.'</span></li>';
                                    $content .= '<li style="'. $box_modal_p_li .'">Meal preferences : <span style="'. $red_color .'">'. $meals .', '.$mealsTrips.'</span></li>';
                                    $content .= '<li style="'. $box_modal_p_li .'">Destination(s) : <span style="'. $red_color .'">'.$desc.'</span></li>';
                                    $content .= '<li style="'. $box_modal_p_li .'">Describe your project and outlook of the trip : <p style="'. $red_color .'">'.$otherDest.'</p></li>';
                                    $content .= '<li style="'. $box_modal_p_li .'">Tour style(s): <span style="'. $red_color .'">'.$tour .'</span></li>';
                                $content .= '</ul>';
                            $content .='</div>';
                        $content .= '</div>';
                        /*$content .= '<div>';
                            $content .= '<h3 style="'. $h3 .'">To know you better</h3>';
                            $content .= '<div style="'. $box_modal .'">';
                                $content .= '<ul style="'. $box_modal_ul  .'">';
                                    $content .= '<li style="'. $box_modal_p_li .'">Describe your hobbies. passion and what you dislike : <p style="'. $red_color .'">'. $hobbies .'</p></li>';
                                    $content .= '<li style="'. $box_modal_p_li .'">Describe your last long haul travel experience : <p style="'. $red_color .'">'.$lastLong.'</p></li>';
                                $content .= '</ul>';
                            $content .='</div>';
                        $content .= '</div>';*/
                        if($fullNameIntro != "" || $titleIntro != ""){
                            $content .= '<div>';
                                $content .= '<h3 style="'. $h3 .'">Sponsorship</h3>';
                                $content .= '<div  style="'. $box_modal .'">';
                                    $content .= '<ul style="'. $box_modal_ul  .' padding-left: 17px;">';
                                        $content .= '<li style="'. $box_modal_p_li .'">Are you recommended by an existing BiiG Holiday customer? : <span style="'. $red_color .'">Yes</span></li>';
                                        $content .= '<li style="'. $box_modal_p_li .'">Sponsored by: <span style="'. $red_color .'">'. $titleIntro.$fullNameIntro .'</span></li>';
                                    $content .= '</ul>';
                                $content .= '</div>';
                            $content .= '</div>';
                        }else{
                            $content .= '<div>';
                                $content .= '<h3 style="'. $h3 .'">Sponsorship</h3>';
                                $content .= '<div  style="'. $box_modal .'">';
                                    $content .= '<ul style="'. $box_modal_ul  .' padding-left: 17px;">';
                                        $content .= '<li style="'. $box_modal_p_li .'">Are you recommended by an existing BiiG Holiday customer? : <span style="'. $red_color .'">No</span></li>';
                                    $content .= '</ul>';
                                $content .= '</div>';
                            $content .= '</div>';
                        }
                    $content .='</div>';    
                    $content .= '<ul style="'. $about_box_ul . $list_button_2 .'">';
                        $content .= '<li style="'. $list_button_li .'"><a href="'.route('home').'" style="'. $list_button_li_a .'" onMouseOver="'. $onMouseOver .'" onMouseOut="'. $onMouseOut .'">Send another request</a></li>';
                        $content .= '<li style="'. $list_button_li_right .'"><a href="'.route('home').'" style="'. $list_button_li_a_right .'" onMouseOver="'. $onMouseOver .'" onMouseOut="'. $onMouseOut .'">View all tours</a></li>';
                    $content .= '</ul>';
                    $content .= '<div style="'. $share_box .'">';
                        $content .= '<h3 style="'. $share_h3 .'">Follow us on</h3>';
                        $content .= '<ul style="'. $about_box_ul . $share_ul .'">';
                            $content .= '<li style="'. $share_li .'">';
                                $content .= '<a href="https://instagram.com/" target="_blank" style="'. $share_li_a .'">';
                                    $content .= '<img src="'.asset('public/images/email_icon/instagram.png').'" alt="" style="'. $img . '" />';
                                $content .= '</a>';
                            $content .= '</li>';
                            $content .= '<li style="'. $share_li .'">';
                                $content .= '<a href="https://facebook.com/" target="_blank" style="'. $share_li_a .'">';
                                    $content .= '<img src="'.asset('public/images/email_icon/facebook.png').'" alt="" style="'. $img . '" />';
                                $content .= '</a>';
                            $content .= '</li>';
                            $content .= '<li style="'. $share_li .'">';
                                $content .= '<a href="https://twitter.com/" target="_blank" style="'. $share_li_a .'">';
                                    $content .= '<img src="'.asset('public/images/email_icon/twitter.png').'" alt="" style="'. $img .  '" />';
                                $content .= '</a>';
                            $content .= '</li>';
                            $content .= '<li style="'. $share_li .'">';
                                $content .= '<a href="https://youtube.com/ target="_blank" style="'. $share_li_a .'">';
                                    $content .= '<img src="'.asset('public/images/email_icon/youtube.png').'" alt="" style="'. $img . '" />';
                                $content .= '</a>';
                            $content .= '</li>';
                            $content .= '<li style="'. $share_li .'">';
                                $content .= '<a href="https://pinterest.com/" target="_blank" style="'. $share_li_a .'">';
                                    $content .= '<img src="'.asset('public/images/email_icon/pinterest.png').'" alt="" style="'. $img . '" />';
                                $content .= '</a>';
                            $content .= '</li>';
                        $content .= '</ul>';
                    $content .= '</div>';
                    $content .= '<div style="'. $footer .'">';
                        $content .= '<ul style="'. $about_box_ul . $footer_ul .'">';
                            $content .= '<li style="'. $footer_li .'">';
                                $content .= '<span style="'. $footer_span .'">';
                                    $content .= '<img src="'.asset('public/images/email_icon/phone.png').'" alt="" style="'. $img . '" />';
                                $content .= '</span>';
                                $content .= 'Hotline Laos *';
                                $content .= '<p><a href="tel:+856 20 9596 9226" style="'. $footer_li_a .'"><img src="'.asset('public/images/email_icon/laos-icon.png').'" alt="" style=" margin-right: 5px; '. $img . '" />+856 20 9596 9226</a></p>';
                            $content .= '</li>';
                            $content .= '<li style="'. $footer_li .'">';
                                $content .= '<span style="'. $footer_span .'">';
                                    $content .= '<img src="'.asset('public/images/email_icon/phone.png').'" alt="" style="'. $img . '" />';
                                $content .= '</span>';
                                $content .= 'Hotline Vietnam *';
                                $content .= '<p><a href="tel:+84 977 247 394" style="'. $footer_li_a .'"><img src="'.asset('public/images/email_icon/vietnam-icon.png').'" alt="" style=" margin-right: 5px; '. $img . '" />+84 977 247 394</a></p>';
                            $content .= '</li>';
                            $content .= '<li style="'. $footer_li .'">';
                                $content .= '<span style="'. $footer_span .'">';
                                    $content .= '<img src="'.asset('public/images/email_icon/envelope-small.png').'" alt="" style="'. $img .'" />';
                                $content .= '</span>';
                                $content .= 'Email';
                                $content .= '<p><a href="mailto:'.$mailSystem.'" style="'. $footer_li_a .'">'.$mailSystem.'</a></p>';
                            $content .= '</li>';
                            $content .= '<li style="'. $footer_li .'">';
                                $content .= '<span style="'. $footer_span .'">';
                                    $content .= '<img src="'.asset('public/images/email_icon/global.png').'" alt="" style="'. $img .'" />';
                                $content .= '</span>';
                                $content .= 'Website';
                                $content .= '<p><a href="'.route('home').'" style="'. $footer_li_a .'">'. $domain .'</a></p>';
                            $content .= '</li>';
                        $content .= '</ul>';
                    $content .= '</div>';
                    $content .= '<p style="clear:both;'. $note .'">* Call us free on whatsapp. Messenger. Skype</p>';
                $content .= '</div>';
                //mail admin
                // $data = array( 'email' => $email, 'from' => $mailSystem, 'fullName' => $fullName, 'content'=> $content);
                // Mail::send( 'mails.admin.contact', compact('data'), function( $message ) use ($data){
                //     $message->to($data['from'])
                //             ->from( $data['email'], $data['fullName'] )
                //             ->subject('[Contact to BiigHoliday] - '.$data['fullName']);
                // });
                $data = array( 'email' => $email, 'from' => '8085678@gmail.com', 'fullName' => $fullName, 'descTitle' => $descTitle, 'dateTitle' => $dateTitle, 'duration' => $duration, 'content'=> $content);
                Mail::send( 'mails.admin.create_my_trip', compact('data'), function( $message ) use ($data){
                    $message->to($data['from'])
                            ->from( $data['email'], $data['fullName'] )
                            ->subject('[Sonasia Holiday] '.$data['fullName'].' / '.$data['descTitle'].' / '.$data['dateTitle'].' / '.$data['duration'].'days');
                });
                //mail customer
                $data = array( 'email' => $email, 'from' => $email, 'fullName' => $fullName, 'descTitle' => $descTitle, 'dateTitle' => $dateTitle, 'duration' => $duration  ,'content' => $content);
                Mail::send( 'mails.create_my_trip', compact('data'), function( $message ) use ($data){
                    $message->to($data['email'])
                            ->from( $data['from'], '[Sonasia Holiday]')
                            ->subject('[Sonasia Holiday] '.$data['fullName'].' / '.$data['descTitle'].' / '.$data['dateTitle'].' / '.$data['duration'].'days');
                });
                return 'true';
            endif;
            return 'if';
        endif;
        return 'false';
    }
    /*
    * Send mail personlize by ajax
    */
    public function updatePersonalize(Request $request){
        // $alert = "error";
        if($request->ajax()):
            $fullName = $request->title.$request->fullName;
            $phone = $request->numberPhone;
            $email = $request->email;
            $ageGroup = $request->ageGroup;
            $newsletter = $request->newsletter;
            $condition = $request->condition;
            $numAdult = $request->numAdult;
            $numChild = $request->numChild;
            $numBaby = $request->numBaby;
            $numTeenager = $request->numTeenager;
            $arrivalDate = $request->arrivalDate;
            $duration = $request->duration;
            $explainTrip = $request->explainTrip;
            $otherDest = $request->otherDest;
            $budgetPerson =  $request->budgetPerson;
            $currencyPerson = $request->currencyPerson;
            $accommodation = $request->accommodation;
            $accommon = $request->accommon;
            $physical = $request->physical;
            $project = $request->project;
            $meals= $request->meals;
            $mealsTrips = $request->mealsTrips;
            $doubleRoom = $request->doubleRoom;
            $twinRoom = $request->twinRoom;
            $individualRoom = $request->individualRoom;
            $tripleRoom = $request->tripleRoom;
            $rooms = "";
            if(intval($doubleRoom) > 0){
                if( $rooms == ""){
                    $rooms .= $doubleRoom." double room ";
                }else{
                    $rooms .= ", ".$doubleRoom." double rooms ";
                }
            }
            if(intval($twinRoom) > 0){
                if( $rooms == ""){
                    $rooms .= $twinRoom. " twin rooms";
                }else{
                    $rooms .=", ".$twinRoom. " twin rooms";
                }
            }
            if(intval($individualRoom) > 0){
                if( $rooms == ""){
                    $rooms .= $individualRoom." individual room";
                }else{
                    $rooms .= ", ".$individualRoom." individual room";
                }
            }
            if(intval($tripleRoom) > 0){
                if( $rooms == ""){
                    $rooms .= $tripleRoom." triple rooms ";
                }else{
                    $rooms .=", ".$tripleRoom." triple rooms ";
                }
            }
            $canContact = $request->canContact;
            $titleIntro = $request->titleIntro;
            $fullNameIntro = $request->fullNameIntro;
            $phoneSystem = phone();
            $mailSystem = mailSystem();
            $domain = $request->getHost();
            $splitDate = explode(',',$arrivalDate);
            $replaceDate = str_replace('/', '-', $splitDate[1]);
            $dateTitle = date("d M Y", strtotime($replaceDate));
            // content
            if(!empty($fullName) && !empty($email) && !empty($ageGroup)  && !empty($phone) && !empty($arrivalDate) && intval($numAdult) > 0 && !empty($explainTrip) && !empty($condition) ) : 
                $h3 = 'font-size: 16px;line-height:31px;background-color:#666;border-radius: 10px; margin: 0;color: #fff;text-align: center; ';
                $fleft = 'float: left; width: 100%;';
                $overflow = 'overflow: hidden';
                $wrapper = 'font-size: 15px; line-height: 21px; color: #666; font-family: Arial; background-color: #fff; width: 600px; margin: 0 auto; -webkit-overflow-scrolling: touch; overflow: auto;';
                $header = 'width: 100%;';
                $logo ='display: block;';
                $container_fluid = 'padding: 0 40px; clear: both;';
                $box_modal = 'padding: 10px; text-align: left;';
                $box_modal_ul = 'padding-left: 25px; margin: 0;';
                $box_modal_p_li = 'color: #555; position: relative; margin-left: 0;';
                $about_box = 'background-color: #f1f1f1;padding:18px 34px 44px; text-align: center; border-bottom-right-radius: 10px; border-bottom-left-radius: 10px;';
                $about_box_ul = 'padding-left:0 ;list-style: none; margin: 0; color: #7e7e7e;';
                $about_box_info_li = 'margin-bottom: 22px; display: block; margin-left: 0;';
                $list_button = 'margin-top: 25px;';
                $list_button_2 = 'margin-bottom: 25px; background-color:#f1f1f1; padding: 20px 0; border-radius:10px;';
                $list_button_li = 'text-align: center;  margin: 0 0 15px 0;';
                $list_button_li_right = 'text-align: center; margin: 0 ;';
                $list_button_li_a = 'display: block; width: 300px; max-width: 100%; line-height: 33px; background-color: #e73361;color: #fff; border-radius: 10px; text-decoration: none; margin: 0 auto;';
                $list_button_li_a_right = 'display: block; width: 300px; max-width: 100%; line-height: 33px;background-color: #34e6d0;color: #fff; border-radius: 10px; text-decoration: none;  margin: 0 auto;';
                $red_color = 'color: #e73362;';
                $button_group = 'background-color: #f1f1f1; margin-bottom: 50px; border-radius: 10px;';
                $share_box = 'background-color: #f1f1f1; border-top-left-radius: 10px; border-top-right-radius: 10px;';
                $share_h3 = 'color: #666; font-size: 14px; line-height: 20px; margin: 19px 0 25px; text-align: center;';
                $share_ul = 'overflow: hidden;';
                $share_li = 'float:left; width: 20%; max-width: 100%; max-height: 100%; margin: 0  auto; box-sizing: border-box; margin-bottom: 15px;';
                $share_li_a = 'width: 30px; height: 30px; line-height: 30px; text-align: center; max-width: 100%; margin: 0 auto; background-color: #e73361; border-radius: 5px; display: block;';
                $footer = 'background-color: #666; clear: both;';
                $footer_ul = 'overflow:hidden; padding: 20px 0;';
                $footer_li = 'width: 50%; float: left; color: #fff; max-width: 100%; max-height: 100%; margin: 0  auto; box-sizing: border-box; text-align: center;';
                $footer_li_a = 'color: inherit; text-decoration: underline; font-size: 14px;';
                $footer_span = 'border-radius: 50%; width: 25px; height: 25px; line-height: 25px; text-align: center; background-color: #fff; display: inline-block; margin-right: 6px;';   
                $wrap_img = 'margin: 30px 0 25px; text-align: center;';
                $img = 'display: inline-block; max-width: 100%; height: auto; vertical-align: middle;'; 
                $note = 'text-align: right; color: #666; margin-top: 10px; font-size: 11px; line-height: 18px';
                $onMouseOver = "this.style.backgroundColor='#e73361';";
                $onMouseOut = "this.style.backgroundColor ='#d9d9d9';";
                $content = '<div style="'. $wrapper .'">';
                    $content .= '<div style="'. $header . $fleft. '">';
                        $content .= '<a href="'.route('home').'" target="_blank" style="'. $logo .'"><img style="'.$img.'" src="'.asset('public/images/email_icon/banner-mail.png').'" alt="BiiGHoliday"></a>';
                    $content .= '</div> ';
                    $content .= '<div style="'. $container_fluid .'">'; 
                        $content .= '<div style="'. $about_box .'">';
                            $content .= '<ul style= "'. $about_box_ul .'">';
                                $content .= '<li style="'.  $about_box_info_li .'">'.$fullName.'</li>';
                                $content .= '<li style="color: #e62757; font-weight: bold;'. $about_box_info_li .' ">Greetings from BiiG Holiday !</li>';
                                $content .= '<li style="'.  $about_box_info_li .'">Many thanks for your interest.</li>';
                                $content .= '<li style="'.  $about_box_info_li .'">One of our travel consultants will contact you shortly to address <br/> your query.</li>';
                                $content .= '<li style="'.  $about_box_info_li .' margin-bottom:0;">In the meantime. you can review your message as detailed below.</li>';
                            $content .= '</ul>';
                            $content .= '<ul style="'. $about_box_ul . $list_button .'">';
                                $content .= '<li style="'. $list_button_li .'"><a href="'.route('home').'" style="'. $list_button_li_a .'" onMouseOver="'. $onMouseOver .'" onMouseOut="'. $onMouseOut .'">Send another request</a></li>';
                                $content .= '<li style="'. $list_button_li_right .'"><a href="'.route('home').'" style="'. $list_button_li_a_right .'" onMouseOver="'. $onMouseOver .'" onMouseOut="'. $onMouseOut .'">View all tours</a></li>';
                            $content .= '</ul>';
                        $content .= '</div>';
                    $content .= '</div>';
                    $content .= '<div style="'. $wrap_img .'">';
                        $content .= '<img src="'.asset('public/images/email_icon/base_fill_mail.png').'" alt="bee" style="'. $img .'" />';
                    $content .= '</div>';
                    $content .= '<ul style= "'. $about_box_ul .'margin-bottom: 30px; text-align: center;">';
                        $content .= '<li style="font-weight: bold;'. $about_box_info_li .' ">Personalization of "The Real Luang Prabang" tour</li>';
                        $content .= '<li style="'.  $about_box_info_li .'margin-bottom:0;">Flow the link below to check the tour detail</li>';
                        $content .= '<li style="'.  $about_box_info_li .' margin-bottom:0;"><a target="_blank" href="http://biigholiday.dsmart.vn/tours/single/6-day-luang-prabang-family-tour" style="'. $red_color .'text-decoration: none;">'.$domain.'/tours/the-real-luang-prabang.html</a></li>';
                    $content .= '</ul>';
                    $content .= '<div style="margin-bottom: 50px;">';
                        $content .= '<div>';
                            $content .= '<h3 style="'. $h3 .'">Your personal information</h3>';
                            $content .= '<div style="'. $box_modal .'">';
                                $content .= '<ul style="'. $box_modal_ul .'">';
                                    $content .= '<li style="'. $box_modal_p_li .'">Name: <span style="'. $red_color .'"> '.$fullName.' </span></li>';
                                    $content .= '<li style="'. $box_modal_p_li .'">Phone number: <span style="'. $red_color .'"> '.$phone.' </span></li>';
                                    $content .= '<li style="'. $box_modal_p_li .'">Age Group: <span style="'. $red_color .'"> '.$ageGroup.' </span></li>';
                                    $content .= '<li style="'. $box_modal_p_li .'">Email: <a href="'.$email.'" target="_blank" style="'. $red_color .'"> '.$email.' </a></li>';
                                    if(intval($numChild) > 0 || intval($numBaby) > 0){
                                       if(intval($numChild) > 0 && intval($numBaby) == 0){
                                            $content .= '<li style="'. $box_modal_p_li .'">Number of Travelers: <span style="'. $red_color .'"> Adult: '.$numAdult.' , Child 2-12 y.o: '.$numChild.'  </span></li>';
                                       }elseif(intval($numChild) == 0 && intval($numBaby) > 0){
                                            $content .= '<li style="'. $box_modal_p_li .'">Number of Travelers: <span style="'. $red_color .'"> Adult: '.$numAdult.' , Baby < 2 y.o: '.$numBaby.'  </span></li>';
                                       }else{
                                            $content .= '<li style="'. $box_modal_p_li .'">Number of Travelers: <span style="'. $red_color .'"> Adult: '.$numAdult.' , Child 2-12 y.o: '.$numChild.' / Baby < 2 y.o: '.$numBaby.'  </span></li>';
                                       }
                                    }else{
                                        $content .= '<li style="'. $box_modal_p_li .'">Number of Travelers: <span style="'. $red_color .'">  Adult: '.$numAdult.' </span></li>';
                                    }
                                    $content .= '<li style="'. $box_modal_p_li .'">Physical conditions of participants: <span style="'. $red_color .'"> '.$condition.' </span></li>';
                                    $content .= '<li style="'. $box_modal_p_li .'">Newsletter: <span style="'. $red_color .'"> '.$newsletter.' </span></li>';
                                $content .= '</ul>';
                            $content .= '</div>';
                        $content .= '</div>';
                        $content .= '<div style="clear: both;">';
                            $content .= '<h3 style="'. $h3 .'">Your project information</h3>';
                            $content .= '<div style="'. $box_modal .'">';
                                $content .= '<ul style="'. $box_modal_ul .'">';
                                    $content .= '<li style="'. $box_modal_p_li .'">Arrival date : <span style="'. $red_color .'">'. $arrivalDate .'</span></li>';
                                    $content .= '<li style="'. $box_modal_p_li .'">Duration : <span style="'. $red_color .'">'.$duration.'days</span></li>';
                                    $content .= '<li style="'. $box_modal_p_li .'">Budget per person : <span style="'. $red_color .'">'.$budgetPerson.' '.$currencyPerson.'</span></li>';
                                    $content .= '<li style="'. $box_modal_p_li .'">Accommodation type : <span style="'. $red_color .'">'.$accommodation.'</span></li>';
                                    $content .= '<li style="'. $box_modal_p_li .'">Number of rooms : <span style="'. $red_color .'">'.$rooms.'</span></li>';
                                    $content .= '<li style="'. $box_modal_p_li .'">Meal preferences : <span style="'. $red_color .'">'. $meals .', '.$mealsTrips.'</span></li>';
                                    $content .= '<li style="'. $box_modal_p_li .'">What you expect from this trip : <p style="'. $red_color .'">'. $explainTrip .'</p></li>';
                                    $content .= '<li style="'. $box_modal_p_li .'">Is there anything you want to personalize : <p style="'. $red_color .'">'. $otherDest .'</p></li>';
                                $content .= '</ul>';
                            $content .='</div>';
                        $content .= '</div>';
                        if($fullNameIntro != "" || $titleIntro != ""){
                            $content .= '<div>';
                                $content .= '<h3 style="'. $h3 .'">Sponsorship</h3>';
                                $content .= '<div  style="'. $box_modal .'">';
                                    $content .= '<ul style="'. $box_modal_ul  .' padding-left: 17px;">';
                                        $content .= '<li style="'. $box_modal_p_li .'">Are you recommended by an existing BiiG Holiday customer? : <span style="'. $red_color .'">Yes</span></li>';
                                        $content .= '<li style="'. $box_modal_p_li .'">Sponsored by: <span style="'. $red_color .'">'. $titleIntro.$fullNameIntro .'</span></li>';
                                    $content .= '</ul>';
                                $content .= '</div>';
                            $content .= '</div>';
                        }else{
                            $content .= '<div>';
                                $content .= '<h3 style="'. $h3 .'">Sponsorship</h3>';
                                $content .= '<div  style="'. $box_modal .'">';
                                    $content .= '<ul style="'. $box_modal_ul  .' padding-left: 17px;">';
                                        $content .= '<li style="'. $box_modal_p_li .'">Are you recommended by an existing BiiG Holiday customer? : <span style="'. $red_color .'">No</span></li>';
                                    $content .= '</ul>';
                                $content .= '</div>';
                            $content .= '</div>';
                        }
                    $content .='</div>';    
                    $content .= '<ul style="'. $about_box_ul . $list_button_2 .'">';
                        $content .= '<li style="'. $list_button_li .'"><a href="'.route('home').'" style="'. $list_button_li_a .'" onMouseOver="'. $onMouseOver .'" onMouseOut="'. $onMouseOut .'">Send another request</a></li>';
                        $content .= '<li style="'. $list_button_li_right .'"><a href="'.route('home').'" style="'. $list_button_li_a_right .'" onMouseOver="'. $onMouseOver .'" onMouseOut="'. $onMouseOut .'">View all tours</a></li>';
                    $content .= '</ul>';
                    $content .= '<div style="'. $share_box .'">';
                        $content .= '<h3 style="'. $share_h3 .'">Follow us on</h3>';
                        $content .= '<ul style="'. $about_box_ul . $share_ul .'">';
                            $content .= '<li style="'. $share_li .'">';
                                $content .= '<a href="https://instagram.com/" target="_blank" style="'. $share_li_a .'">';
                                    $content .= '<img src="'.asset('public/images/email_icon/instagram.png').'" alt="" style="'. $img . '" />';
                                $content .= '</a>';
                            $content .= '</li>';
                            $content .= '<li style="'. $share_li .'">';
                                $content .= '<a href="https://facebook.com/" target="_blank" style="'. $share_li_a .'">';
                                    $content .= '<img src="'.asset('public/images/email_icon/facebook.png').'" alt="" style="'. $img . '" />';
                                $content .= '</a>';
                            $content .= '</li>';
                            $content .= '<li style="'. $share_li .'">';
                                $content .= '<a href="https://twitter.com/" target="_blank" style="'. $share_li_a .'">';
                                    $content .= '<img src="'.asset('public/images/email_icon/twitter.png').'" alt="" style="'. $img .  '" />';
                                $content .= '</a>';
                            $content .= '</li>';
                            $content .= '<li style="'. $share_li .'">';
                                $content .= '<a href="https://youtube.com/ target="_blank" style="'. $share_li_a .'">';
                                    $content .= '<img src="'.asset('public/images/email_icon/youtube.png').'" alt="" style="'. $img . '" />';
                                $content .= '</a>';
                            $content .= '</li>';
                            $content .= '<li style="'. $share_li .'">';
                                $content .= '<a href="https://pinterest.com/" target="_blank" style="'. $share_li_a .'">';
                                    $content .= '<img src="'.asset('public/images/email_icon/pinterest.png').'" alt="" style="'. $img . '" />';
                                $content .= '</a>';
                            $content .= '</li>';
                        $content .= '</ul>';
                    $content .= '</div>';
                    $content .= '<div style="'. $footer .'">';
                    $content .= '<ul style="'. $about_box_ul . $footer_ul .'">';
                        $content .= '<li style="'. $footer_li .'">';
                            $content .= '<span style="'. $footer_span .'">';
                                $content .= '<img src="'.asset('public/images/email_icon/phone.png').'" alt="" style="'. $img . '" />';
                            $content .= '</span>';
                            $content .= 'Hotline Laos *';
                            $content .= '<p><a href="tel:+856 20 9596 9226" style="'. $footer_li_a .'"><img src="'.asset('public/images/email_icon/laos-icon.png').'" alt="" style=" margin-right: 5px; '. $img . '" />+856 20 9596 9226</a></p>';
                        $content .= '</li>';
                        $content .= '<li style="'. $footer_li .'">';
                            $content .= '<span style="'. $footer_span .'">';
                                $content .= '<img src="'.asset('public/images/email_icon/phone.png').'" alt="" style="'. $img . '" />';
                            $content .= '</span>';
                            $content .= 'Hotline Vietnam *';
                            $content .= '<p><a href="tel:+84 977 247 394" style="'. $footer_li_a .'"><img src="'.asset('public/images/email_icon/vietnam-icon.png').'" alt="" style=" margin-right: 5px; '. $img . '" />+84 977 247 394</a></p>';
                        $content .= '</li>';
                        $content .= '<li style="'. $footer_li .'">';
                            $content .= '<span style="'. $footer_span .'">';
                                $content .= '<img src="'.asset('public/images/email_icon/envelope-small.png').'" alt="" style="'. $img .'" />';
                            $content .= '</span>';
                            $content .= 'Email';
                            $content .= '<p><a href="mailto:'.$mailSystem.'" style="'. $footer_li_a .'">'.$mailSystem.'</a></p>';
                        $content .= '</li>';
                        $content .= '<li style="'. $footer_li .'">';
                            $content .= '<span style="'. $footer_span .'">';
                                $content .= '<img src="'.asset('public/images/email_icon/global.png').'" alt="" style="'. $img .'" />';
                            $content .= '</span>';
                            $content .= 'Website';
                            $content .= '<p><a href="'.route('home').'" style="'. $footer_li_a .'">'. $domain .'</a></p>';
                        $content .= '</li>';
                    $content .= '</ul>';
                $content .= '</div>';
                    $content .= '<p style="clear:both;'. $note .'">* Call us free on whatsapp. Messenger. Skype</p>';
                $content .= '</div>';
                //mail admin
                // $data = array( 'email' => $email, 'from' => $mailSystem, 'fullName' => $fullName, 'content'=> $content);
                // Mail::send( 'mails.admin.contact', compact('data'), function( $message ) use ($data){
                //     $message->to($data['from'])
                //             ->from( $data['email'], $data['fullName'] )
                //             ->subject('[Contact to BiigHoliday] - '.$data['fullName']);
                // });
                $data = array( 'email' => $email, 'from' => '8085678@gmail.com', 'fullName' => $fullName, 'dateTitle' => $dateTitle, 'duration' => $duration, 'content'=> $content);
                Mail::send( 'mails.admin.create_my_trip', compact('data'), function( $message ) use ($data){
                    $message->to($data['from'])
                            ->from( $data['email'], $data['fullName'] )
                            ->subject('[Sonasia Holiday] '.$data['fullName'].' / '.$data['dateTitle'].' / '.$data['duration'].'days');
                });
                //mail customer
                $data = array( 'email' => $email, 'from' => $email, 'fullName' => $fullName, 'dateTitle' => $dateTitle, 'duration' => $duration  ,'content' => $content);
                Mail::send( 'mails.create_my_trip', compact('data'), function( $message ) use ($data){
                    $message->to($data['email'])
                            ->from( $data['from'], '[Sonasia Holiday]')
                            ->subject('[Sonasia Holiday] '.$data['fullName'].' / '.$data['dateTitle'].' / '.$data['duration'].'days');
                });
                // $alert = 'Thank you sent request to the BiigHoliday, we will reeback you in the early time.';
            return 'true';
            endif;
            return 'if';
        endif;
        return 'false';
    }
    /*
    * Send mail feedback by ajax
    */
    public function updateFeedback(Request $request){
        if($request->ajax()):
            $fullName = $request->title.$request->fullName;
            $phone = $request->numberPhone;
            $email = $request->email;
            $newsletter = $request->newsletter;
            $upload_files = explode(",", $request->upload_files);
        endif;
    }
    public function fileUpload(Request $request){
    $delete_file = 0;
    if(isset($_POST['delete_file'])){ 
            $delete_file = $_POST['delete_file'];
        }
    if ($delete_file == 0 ) {
            $file = $request->file('file');  
            if($file){
              $file_name = $file->getClientOriginalName();
              $file_extension = $file->getClientOriginalExtension();
              $file_size = $file->getSize();
              $file_mime = $file->getMimeType();
              $file_attributes = getimagesize($file->getRealPath());
              $file_url = str_slug(str_random(4)."_".$file_name).'.'.$file_extension;
              $file->move("public/uploads/",$file_url);
              $media = new Media();
              $media->title = $file_name;
              $media->alt = $file_name;
              $media->image_path = $file_url;
              $media->type = $file_extension;
              $media->size = $file_size;
              $media->cat_ids = '321';
              if(Auth::check()){
                $media->user_id = Auth::User()->id;
              }else{
                 $media->user_id = '108';
              }
              if($file_attributes){
                $media->width = $file_attributes[0];
                $media->height = $file_attributes[1];
              }
              $media->save();
        }
        $response = array (
            'status'    => 'success',
            'info'      => 'Your file has been uploaded successfully.',
            'file_link' => getImgUrl($media->id),
            'id' => $media->id,
        );
        echo json_encode($response);
    }
    //Remove file
    if( $delete_file == 1 ){
        $id = $request->id;
        // Check if file is exists
        if($id) {
            $media = Media::find($id);
            $path = public_path() . '/uploads/' . $media->image_path; 
            if(file_exists($path)) {
                unlink($path);
                $media->delete();
            }
            // Be sure we deleted the file
            if ( !file_exists($id) ) {
                $response = array (
                    'status' => 'success',
                    'info'   => 'Successfully Deleted.'
                );
            } else {
                // Check the directory's permissions
                $response = array (
                    'status' => 'error',
                    'info'   => 'We screwed up, the file can\'t be deleted.'
                );
            }
        } else {
            // Something weird happend and we lost the file
            $response = array (
                'status' => 'error',
                'info'   => 'Couldn\'t find the requested file :('
            );
        }
        // Return the response
        echo json_encode($response);
        exit;
        }
    }
}