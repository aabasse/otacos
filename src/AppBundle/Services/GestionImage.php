<?php
namespace AppBundle\Services;
use AppBundle\Services\SimpleImage;
/**
* 
*/
class GestionImage
{
	static $TRACE_PHOTO_IMAGE_URL = "uploads/images/trace/";
    static $RECEPTION_PHOTO_IMAGE_URL = "uploads/images/reception/";
    static $EVENEMENT_IMAGE_URL = "uploads/images/evenement/";
    private $profil_url = 'uploads/images/profil/';

    public function getUrl($type){
        switch ($type) {
            case 'trace':
                $image_url = $this::$TRACE_PHOTO_IMAGE_URL;
                break;
            case 'reception':
                $image_url = $this::$RECEPTION_PHOTO_IMAGE_URL;
                break;
        }

        return $image_url;
    }

	public function telecharger($file,  $options)
	{
        $options['dossier'] = isset($options['dossier']) ? $options['dossier'] : '';
        $options['prefix'] = isset($options['prefix']) ? $options['prefix'] : '';
        $options['type'] = isset($options['type']) ? $options['type'] : 'trace';


        $image_url = $this->getUrl($options['type']);

		$nomImage = null;
		if($file != null)
        {
            $extension = $file->guessExtension();
            if (!$extension) {
                // extension cannot be guessed
                $extension = 'bin';
            }
            $nomImage = $options['prefix'].'-'.rand(1, 99999).'.'.$extension;
            $totalName = $image_url.'temp_'.$nomImage;

            $file->move($image_url, 'temp_'.$nomImage);

            try {
                ini_set ('gd.jpeg_ignore_warning', 1);
                $img2 = new SimpleImage($totalName);
                $img2->best_fit(200, 200);
                $img2->save($image_url.'min_'.$nomImage);
                
                $img1 = new SimpleImage($totalName);
                $img1->best_fit(2000, 2000);
                $img1->save($image_url.$nomImage);  

            } catch (Exception $e) {
                //echo 'Exception reçue : ',  $e->getMessage(), "\n";
                $nomImage = null;
            }
            finally {
                @unlink($totalName);
            }


        }
        return $nomImage;
	}

    public function telechargerProfil($file)
    {
        $fileName = md5(uniqid()).'.'.$file->guessExtension();
        //Enregistre le fichier pour le modifier apres
        $file->move( $this->profil_url, $fileName);
        // Recupere le fichier
        $totalName = $this->profil_url.$fileName;

        /*
        //pour cover
        $img = new SimpleImage($totalName);
        $img->blur('gaussian', 40);
        $img->thumbnail(1000, 200);
        $img->save($this->profil_url.'cover_'.$fileName);*/
        ini_set ('gd.jpeg_ignore_warning', 1);
        $img2 = new SimpleImage($totalName);
        $img2->best_fit(200, 200);
        $img2->save($this->profil_url.'profil_'.$fileName);

        //echo '<img src="'.$this->profil_url.'cover_'.$fileName.'" />';
        //echo '<img src="'.$this->profil_url.'profil_'.$fileName.'" />';

        @unlink($totalName); // on suprime le fichier

        return $fileName;
    }

    public function supprimerProfil($name)
    {
        //@unlink($this->profil_url.'cover_'.$name);
        @unlink($this->profil_url.'profil_'.$name);
    }

    public function supprimer($name, $type)
    {
        $image_url = $this->getUrl($type);

        @unlink($image_url.$name);
        @unlink($image_url.'min_'.$name);
    }

	/*public function getLesImagesNonNull($files)
	{
		$lesFiles = null;
		foreach ($files as $file) {
            if($file != null)
            {
            	$lesFiles[] = $file;
            }
        }
        return $lesFiles;
	}*/

    static public function slugify($text)
    {
      // replace non letter or digits by -
      $text = preg_replace('~[^\pL\d]+~u', '-', $text);

      // transliterate
      $text = iconv('utf-8', 'us-ascii//TRANSLIT', $text);

      // remove unwanted characters
      $text = preg_replace('~[^-\w]+~', '', $text);

      // trim
      $text = trim($text, '-');

      // remove duplicate -
      $text = preg_replace('~-+~', '-', $text);

      // lowercase
      $text = strtolower($text);

      if (empty($text)) {
        return 'n-a';
      }

      return $text;
    }
}

?>