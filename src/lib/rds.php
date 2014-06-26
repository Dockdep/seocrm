<?php
namespace {
    class rds
    {
        private $api_key;

        function __construct() {
            $this->api_key = '089c370e-d4be-4b95-8847-acbc381f4b89';
        }





        public function getPutDataString($name, $site) {
            $put_data = "
                <InitSession>
                    <Parameters>
                        <TaskVariant>".$name."</TaskVariant>
                    </Parameters>
                    <DomainNames>
                        <string>".$site."</string>
                    </DomainNames>
                </InitSession>";
            return $put_data;
        }

        function echosessionRds( $name, $site) {
            $put_data = $this->getPutDataString($name, $site);
            // Инициализируем запрос для создания сессии
            $ch = curl_init("http://recipdonor.com:998/api/session/new");
// Передаем API ключ
            curl_setopt($ch, CURLOPT_USERPWD, "{$this->api_key}:x");
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
// При инициализации сессии используется метод PUT
            curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "PUT");
// Указываем необходимые заголовки
            curl_setopt($ch, CURLOPT_HTTPHEADER, array(
                "Content-Type: text/xml; charset=utf-8",
                "Content-Length: ".strlen($put_data)));
// Передаем данные для инициализации
            curl_setopt($ch, CURLOPT_POSTFIELDS, $put_data);

// Посылаем запрос
            $initSessionData = curl_exec($ch);
            $responseInfo = curl_getinfo($ch);

            if($responseInfo['http_code'] != 200) exit('Wrong request!');

            curl_close($ch);

// Обрабатываем пришедший ответ
            $sesssionXmlData = new SimpleXMLElement($initSessionData);
// Достаем идентификатор созданой сессии
            $sessionId = $sesssionXmlData->Id;

            $sessionData = null;
            do{
                // Небольшая задержка перед получением данных
                sleep(2);
                // Инициализируем запрос для получения данных сессии
                $ch = curl_init("http://recipdonor.com:998/api/session/get/{$sessionId}");
                // Передаем API ключ
                curl_setopt($ch, CURLOPT_USERPWD, "{$this->api_key}:x");
                curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
                curl_setopt($ch, CURLOPT_HTTPHEADER, array("Content-Type: text/xml; charset=utf-8"));

                // Получаем и обрабатываем пришедший ответ
                $response = curl_exec($ch);
                $responseInfo = curl_getinfo($ch);

                if($responseInfo['http_code'] != 200) exit('Wrong request!');

                $sessionData = new SimpleXMLElement($response);
                curl_close($ch);

                // Повоторяем процедуру пока сессия не будет завершена
            }while($sessionData->SessionStatus != 'Completed' && $sessionData->SessionStatus != 'Bankrupt');

        // Выводим пришедшие данные
            return $sessionData->Domains->DomainData;
        }

        function echositesonipRds($api_key, $site) {
            // Максимальное кол-во результатов
            $count = 10;

// Инициализируем запрос
            $ch = curl_init("http://recipdonor.com:998/api/sitesonip/$site/".$count);

// Передаем API ключ
            curl_setopt($ch, CURLOPT_USERPWD, "{$api_key}:x");
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

// Посылаем запрос
            $sitesOnIp = new SimpleXMLElement(curl_exec($ch));

            $responseInfo = curl_getinfo($ch);
            if($responseInfo['http_code'] != 200) exit('Wrong request!');

            curl_close($ch);
            return $sitesOnIp;
        }


        function echonewRds($name, $way) {
            $put_data = $this->getPutDataString($name, $way);
            // Инициализируем запрос для создания сессии
            $ch = curl_init("http://62.149.1.74:977/api/session/new");
// Передаем API ключ
            curl_setopt($ch, CURLOPT_USERPWD, "{$this->api_key}:x");
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
// При инициализации сессии используется метод PUT
            curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "PUT");
// Указываем необходимые заголовки
            curl_setopt($ch, CURLOPT_HTTPHEADER, array(
                "Content-Type: text/xml; charset=utf-8",
                "Content-Length: ".strlen($put_data)));
// Передаем данные для инициализации
            curl_setopt($ch, CURLOPT_POSTFIELDS, $put_data);

// Посылаем запрос
            $initSessionData = curl_exec($ch);
            $responseInfo = curl_getinfo($ch);

            if($responseInfo['http_code'] != 200) exit('Wrong request!');

            curl_close($ch);
// Обрабатываем пришедший ответ
            $sesssionXmlData = json_decode($initSessionData);
// Достаем идентификатор созданой сессии
            $sessionId = $sesssionXmlData->Id;

            $sessionData = null;
            do{
                // Небольшая задержка перед получением данных
                sleep(2);
                // Инициализируем запрос для получения данных сессии
                $ch = curl_init("http://62.149.1.74:977/api/session/get/{$sessionId}");
                // Передаем API ключ
                curl_setopt($ch, CURLOPT_USERPWD, "{$this->api_key}:x");
                curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
                curl_setopt($ch, CURLOPT_HTTPHEADER, array("Content-Type: text/xml; charset=utf-8"));

                // Получаем и обрабатываем пришедший ответ
                $response = curl_exec($ch);
                $responseInfo = curl_getinfo($ch);

                if($responseInfo['http_code'] != 200) exit('Wrong request!');

                $sessionData = json_decode($response);
                curl_close($ch);

                // Повоторяем процедуру пока сессия не будет завершена
            }while($sessionData->SessionStatus != 'Completed' && $sessionData->SessionStatus != 'Bankrupt');
// Выводим пришедшие данные
               return $sessionData->Domains;
        }
    }


}