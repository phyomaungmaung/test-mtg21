<?php

use Carbon\Carbon;

if (!function_exists('lang')) {
    /**
     * Get the translation.
     *
     * @param  string text
     *
     * @return string
     */
    function lang($text, $parametters = [])
    {
        // $prefix = str_replace(
        // 	'php','',
        // 	config('core.translator.filename')
        // ).".";
        $prefix="";

        $translated = trans("{$prefix}".$text, $parametters);
        return \Illuminate\Support\Str::contains($translated, $prefix) ? $text : $translated;
    }
}

if (!function_exists('is_start_date')) {
    /**
     * Get the translation.
     *
     * @param  string text
     *
     * @return string
     */
    function is_start_date($the_date=null)
    {
        if($the_date==null){
            $deadline = \Carbon\Carbon::createFromFormat('m/d/Y',\Setting::get('CLOSED_FORM_DATE','07/28/2019'));
//            CLOSED_FORM_DATE
        } else if(is_string($the_date)){
            try{
                $the_date = \Carbon\Carbon::createFromFormat('m/d/Y',\Setting::get($the_date,'07/28/2019'));
            }catch (\Exception $e){
                $the_date = Carbon\Carbon::yesterday();
            }

        }
//        return $the_date->isFuture();
        return $the_date->isPast();
    }
}

if (!function_exists('is_deadline')) {
    /**
     * Get the translation.
     *
     * @param  string text
     *
     * @return string
     */
    function is_deadline($deadline=null)
    {
//        $start_judge = Carbon::createFromFormat('m/d/Y', \Setting::get('DATELINE_SUBMIT_FORM_DATE','07/28/2019'));
//        $this->is_deadline_sumbit_form = $start_judge->isPast();
        if($deadline==null){
            $deadline = \Carbon\Carbon::createFromFormat('m/d/Y',\Setting::get('CLOSED_FORM_DATE','07/28/2019'));
//            CLOSED_FORM_DATE
        } else if(is_string($deadline)){
            try{
                $deadline = \Carbon\Carbon::createFromFormat('m/d/Y',\Setting::get($deadline,'07/28/2019'));
            }catch (\Exception $e){
                $deadline = Carbon\Carbon::yesterday();
            }

        }
//        return (\Carbon\Carbon::today()->gt(\Carbon\Carbon::parse($deadline)));
        return $deadline->addDays(1)->isPast();
    }
}

if (!function_exists('sending_email')) {
    /**
     * Get the translation.
     *
     * @param  string text
     *
     * @return boolean
     */
    function sending_email($sender,$name,$reciever,$subject,$view,$content)
    {
        \Mail::send($view, ['content' => $content], function ($message) use ($sender,$name,$reciever,$subject)
        {
            $message->from($sender, $name);
            $message->to($reciever);
            $message->subject($subject);
        });

        return 'true';
    }
}
