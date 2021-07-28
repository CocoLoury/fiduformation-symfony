<?php


namespace App\Service;


use Symfony\Component\DependencyInjection\ParameterBag\ParameterBagInterface;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\String\Slugger\SluggerInterface;

class UploadFileService
{
    protected const UPLOAD_URI = 'upload';
    public const AVATAR_DIR = 'avatar';

    private $params;
    private $slugger;

    public function __construct(ParameterBagInterface $params, SluggerInterface $slugger)
    {
        $this->params = $params;
        $this->slugger = $slugger;
    }

//    public function test()
//    {
//        $s = 'AFRTHRHOIVIEROIERNGOTI?.1263456789"ééé"\'(-èè-("ééé$*ùonvré"\'(-è_ç)';
//        dump($s);
//        dd($this->slugger->slug($s));
//    }

    /**
     * @param UploadedFile $uploadedFile
     * @param string $directory
     * @return string $uri du fichier uploadé
     */
    public function upload(UploadedFile $uploadedFile, string $directory) : string
    {
        $name = uniqid().'-'.$this->slugger->slug($uploadedFile->getClientOriginalName());
        $dir = $this->params->get('public_dir').'/'.self::UPLOAD_URI.'/'.$directory;

        try {
            $uploadedFile->move($dir, $name);
        } catch (\Exception $e) { dd($e->getMessage()); }

        return '/'.self::UPLOAD_URI.'/'.$directory.'/'.$name;
    }
}