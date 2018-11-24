<?php

    class CustomerNumberServices
    {

        public static function incrementAndGetVisitorCounter(): int
        {
            if(!file_exists('../visitor_counter.txt'))
            {
                return false;
            }
            if(!$file_counter = fopen('../visitor_counter.txt', "r+"))
            {
                return false;
            }
            if(!flock($file_counter, LOCK_EX))
            {
                fclose($file_counter);
                return false;
            }
            $counter = fgets($file_counter);
            if(is_numeric($counter))
            {
                $result = (integer) ($counter + 1);
                fseek($file_counter, 0);
                fputs($file_counter, $result);
            }
            else
            {
                $result = false;
            }
            flock($file_counter, LOCK_UN);
            fclose($file_counter);
            return $result;
        }
    
    
        public static function getNumberOfRegisteredUsers(): int
        {
            $parentDao = new UserParentDao(DbConnection::getPDO());

            return $parentDao->getNumberOfParents();

        }
    }