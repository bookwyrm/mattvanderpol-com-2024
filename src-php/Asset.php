<?php

namespace TailCraft\Theme;

class Asset {
  protected $subpath;
  protected $assets_dir = 'assets';

  public function __construct(string $subpath) {
    $this->subpath = $subpath;
  }

  public function url() {
    return sprintf(
      '%s/%s%s',
      get_stylesheet_directory_uri(),
      $this->assets_dir,
      $this->leadingSlashIt($this->subpath)
    );
  }

  public function version() {
    $file_path = parse_url(
      str_replace(
        get_stylesheet_directory_uri(),
        get_stylesheet_directory(),
        $this->url()
      ),
      PHP_URL_PATH
    );
    return filemtime($file_path);
  }

  public function localPath() {
    return './assets' . $this->leadingSlashIt($this->subpath);
  }

  protected function leadingSlashIt(string $path) {
    return substr($path, 0, 1) === '/'
      ? $path
      : '/' . $path
    ;
  }
}


