<?php
class Movie extends Controller
{
    public $ProductModel;
    public function show() {
        $this->view('master', [
            'Page' => 'movie',
            'movieList' => 'Movie List in here'
        ]);
    }
}
