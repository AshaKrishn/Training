<?php
namespace App\Models;

use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Support\Facades\File;
use Spatie\YamlFrontMatter\YamlFrontMatter;
use Symfony\Component\Translation\Dumper\YamlFileDumper;


class post {

    public $title;
    public $date;
    public $excerpt;
    public $body;
    public $slug;
    
    public function __construct($title,$date,$excerpt,$body,$slug)
    {
        $this->title = $title;
        $this->date = $date;
        $this->excerpt = $excerpt;
        $this->body = $body;
        $this->slug = $slug;

    }
    public static function all()
    {
        return collect(File::files(resource_path("books")))
                ->map(function($file){
                    return YamlFrontMatter::parseFile($file);
                })
                ->map(function($document) {
                    return new post($document->title,$document->date,$document->excerpt,$document->body(),$document->slug);
                })
                ->sortBy('date');

        /*
        foreach ($files as $file) {
            $document = YamlFrontMatter::parseFile($file);
            $posts[] = new post($document->title,$document->date,$document->excerpt,$document->body(),$document->slug);
        }
        */
        
        //$files = File::files(resource_path("books/"));
        //return array_map(fn($file) => $file->getContents(),$files);
    }
    public static function find($slug)
    {

        return static::all()->firstWhere('slug', $slug);
       /*
        if (!file_exists($path = resource_path("books/{$slug}.html"))) {
            return redirect('/');
        }
        $document = YamlFrontMatter::parseFile($path);
        return new post($document->title,$document->date,$document->excerpt,$document->body(),$document->slug); //need to cache here
        */
         
    }

    public static function findOrFail($slug)
    {
        $posts = static::find($slug);
        if(!$posts) {
            throw new ModelNotFoundException();
        }
        return $posts;
    }
}

