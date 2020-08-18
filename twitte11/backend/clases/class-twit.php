<?php
    class Twit {
        // private $codigoTwit;
        private $codigoUsuario;
        private $contenidoTwit;
        private $imagen;
        private $cantidadReTwits;
        private $codigoTwitOriginal; // Si !=0 es un retwit, indica el codigo del twit original

        
        public function __construct(
            // $codigoTwit,
            $codigoUsuario,
            $contenidoTwit,
            $imagen,
            $cantidadReTwits,
            $codigoTwitOriginal
        ){
            // $this->codigoTwit = $codigoTwit;
            $this->codigoUsuario = $codigoUsuario;
            $this->contenidoTwit = $contenidoTwit;
            $this->imagen = $imagen;
            $this->cantidadReTwits = $cantidadReTwits;
            $this->codigoTwitOriginal = $codigoTwitOriginal;
        }

        public static function obtenerTwits()
        {
            $contenidoArchivoTwits = file_get_contents('../data/twits.json');
            $twits = json_decode($contenidoArchivoTwits, true);

            $contenidoArchivoUsuarios = file_get_contents('../data/usuarios.json');
            $usuarios = json_decode($contenidoArchivoUsuarios, true);

            $resultado = array();
            for ($i=0; $i < sizeof($twits); $i++)
            {
                for ($j=0; $j < sizeof($usuarios); $j++)
                {
                    if($twits[$i]["codigoUsuario"] == $usuarios[$j]["codigoUsuario"])
                    {
                        $twits[$i]["nombreUsuario"] = $usuarios[$j]["nombre"];
                        $twits[$i]["apellidoUsuario"] = $usuarios[$j]["apellido"];
                    }
                    
                }
                $resultado[] = $twits[$i];
            }

            echo json_encode($resultado);
        }

        public function guardarTwit() // Guardar los nuevos twits
        {
            $contenidoArchivoTwits = file_get_contents('../data/twits.json');
            $twits = json_decode($contenidoArchivoTwits, true);

            $resultado = array();
            for ($i=0; $i < count($twits); $i++) {
            // Si el post a publicar es un retwit, se aumentara la cantidad de retwits del post original
                if ($this->codigoTwitOriginal != 0 && $twits[$i]["codigoTwit"] == $this->codigoTwitOriginal) {
                    $twits[$i]["cantidadReTwits"] += 1;
                }
                $resultado[] = $twits[$i];
            }
            $resultado[] = array(
                "codigoTwit" => date("dmYhisa"), // El codigo del twit sera fecha y hora actual, ejemplo: 17082020120935pm
                "codigoUsuario" => $this->codigoUsuario,
                "contenidoTwit" => $this->contenidoTwit,
                "imagen" => $this->imagen,
                "cantidadReTwits" => $this->cantidadReTwits,
                "codigoTwitOriginal" => $this->codigoTwitOriginal
            );
            $archivo = fopen("../data/twits.json", "w");
            fwrite($archivo, json_encode($resultado));
            fclose($archivo);

            return json_encode($resultado);
        }


        /**
         * Get the value of codigoTwit
         */ 
        // public function getCodigoTwit()
        // {
        //         return $this->codigoTwit;
        // }

        /**
         * Set the value of codigoTwit
         *
         * @return  self
         */ 
        // public function setCodigoTwit($codigoTwit)
        // {
        //         $this->codigoTwit = $codigoTwit;

        //         return $this;
        // }

        /**
         * Get the value of codigoUsuario
         */ 
        public function getCodigoUsuario()
        {
                return $this->codigoUsuario;
        }

        /**
         * Set the value of codigoUsuario
         *
         * @return  self
         */ 
        public function setCodigoUsuario($codigoUsuario)
        {
                $this->codigoUsuario = $codigoUsuario;

                return $this;
        }

        /**
         * Get the value of contenidoTwit
         */ 
        public function getContenidoTwit()
        {
                return $this->contenidoTwit;
        }

        /**
         * Set the value of contenidoTwit
         *
         * @return  self
         */ 
        public function setContenidoTwit($contenidoTwit)
        {
                $this->contenidoTwit = $contenidoTwit;

                return $this;
        }

        /**
         * Get the value of imagen
         */ 
        public function getImagen()
        {
                return $this->imagen;
        }

        /**
         * Set the value of imagen
         *
         * @return  self
         */ 
        public function setImagen($imagen)
        {
                $this->imagen = $imagen;

                return $this;
        }

        /**
         * Get the value of cantidadReTwits
         */ 
        public function getCantidadReTwits()
        {
                return $this->cantidadReTwits;
        }

        /**
         * Set the value of cantidadReTwits
         *
         * @return  self
         */ 
        public function setCantidadReTwits($cantidadReTwits)
        {
                $this->cantidadReTwits = $cantidadReTwits;

                return $this;
        }

        /**
         * Get the value of codigoTwitOriginal
         */ 
        public function getCodigoTwitOriginal()
        {
                return $this->codigoTwitOriginal;
        }

        /**
         * Set the value of codigoTwitOriginal
         *
         * @return  self
         */ 
        public function setCodigoTwitOriginal($codigoTwitOriginal)
        {
                $this->codigoTwitOriginal = $codigoTwitOriginal;

                return $this;
        }
    }
