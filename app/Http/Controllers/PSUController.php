<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class PSUController extends Controller
{
    
     public function welcome()
    {
        return "Welcome to PSUController!\n\n";
 
    }
    public function Mission()
    {
        return "Mission:<br>
        The Pangasinan State University, shall provide a human-centric,<br>
        resilient , and sustainable academic environment to produce dynamic,<br>
        responsive, and future-ready individuals capable of meeting the <br>
        requirements of the local and global communities and industries.<br><br>";
    }


        public function Vision()
        {
            return "Vision:<br>
            To become a leading industry-driven State <br>
            University in the ASEAN region by 2030<br>";
        }


        public function EOMSPolicy()
        {
            return "Equal Opportunity and Meritocracy System (EOMS) Policy: <br><br>
            The Pangasinan State University shall be recognized as an ASEAN premier<br>
            state university that provides quality education and satisfactory<br>
            service delivery through instruction, research, extension and production.<br><br>
            
            We commit our expertise and resources to produce professionals who meet<br>
            the expectations of the industry and other interested parties in the<br>
            national and international community.<br><br>
            
            We shall continuously improve our operations through systems and process<br>
            innovations guided by ethical, intellectual property and technology<br>
            transfer standards in response to the changing educational, scientific <br>
            and technological developments for social responsiveness and in support <br>
            of the institutions strategic direction.<br>";
        }




        //par 2
        public function student($name, $course)
        {
            return "Student Name: $name <br> Course: $course";
        }
}