<?php

///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

namespace 
{
    /**
     * common
     *
     * @author      Roman Telychko
     * @version     0.1.20130712
     */
    class common
    {
        /////////////////////////////////////////////////////////////////////////////
    
        /**
         * common::hashPasswd()
         *
         * @author      Roman Telychko
         * @version     3.0.20131010
         *
         * @param     string      $passwd
         * @return    string      $hash
         */
        public function hashPasswd( $passwd )
        {
            $salt1 = 'IKudI9k4sts40Spu1yAwcxeaD7umJ8aMAYt6Uj862VTHBh55sMi7DPRkvgckXK88ecj6aDy1Q0DYB28ZVuygR6rlqFoRFcKn45XT5gzbADbzNfBHxMgUmEnb79CyFx7O';            # pwgen -s 128
            $salt2 = 'JzbdFHvuEamXvr8jXWCHkoRqXwEQE86NwPH27vxsdp7T3ln1rk2Mbtu9ADAUIgxpDePe9jzT0KpQceQLTFMSl1fZjmYIl1jbRtlNcuFjUaHy5X0FE55MpT8Kf2xZZnGI';            # pwgen -s 128

            $hash = '//'.$salt1.'//'.base64_encode( $passwd ).'//';
            $pieces = str_split( $salt2, 10 );

            for( $i=0; $i<10000; $i++ )
            {
                $hash = hash( 'sha512', $pieces[( $i % 10 )].'|'.$hash );
            }

            return $hash;
        }
    
        /////////////////////////////////////////////////////////////////////////////
    }
}

///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
