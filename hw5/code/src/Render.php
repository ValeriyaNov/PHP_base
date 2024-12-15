<?php

namespace Geekbrains\Application1;

use Twig\Loader\FilesystemLoader;
use Twig\Environment;

class Render {

    private string $viewFolder = '/src/Views/';
    private FilesystemLoader $loader;
    private Environment $environment;




    public function __construct(){
        $this->loader = new FilesystemLoader($_SERVER['DOCUMENT_ROOT'] . $this->viewFolder);
        $this->environment = new Environment($this->loader, [
            //'cache' => $_SERVER['DOCUMENT_ROOT'].'/cache/',
        ]);
    }

    public function renderPage(string $contentTemplateName = 'page-index.twig', array $templateVariables = []) {
        //$template = $this->environment->load('main.twig');
        
        $templateVariables['content_template_name'] = $contentTemplateName;
        $templateVariables['list'] = ['Главная', 'Пользователи'];
        $templateVariables['random_int'] = rand(1, 10000);
        $templateVariables['style'] = file_get_contents('src/Views/style.css');
        try {
            $template = $this->environment->load('main.twig');
            return $template->render($templateVariables);
        } catch (\Throwable $e) {
            return "Error {$e->getCode()}: {$e->getMessage()}";
        }
        
    }
    // public function renderPage(array $props = [], $tplContent = '', $tplMain = 'content/main'): string
    // {
    //     $vars = array_merge($props, [
    //         'template_main' => $tplMain ? "$tplMain.twig" : null,
    //         'template_component' => $tplContent ? "$tplContent.twig" : null,
    //         'title' => $props['title'] ?? '',
    //         'description' => $props['description'] ?? '',
    //         'keywords' => $props['keywords'] ?? '',
    //         'canonical' => $props['canonical'] ?? '/' . ltrim($_SERVER['REQUEST_URI'], '/'),
    //         'content' => $props['content'] ?? '',
    //     ]);
    //     try {
    //         $template = $this->environment->load('main.twig');
    //         return $template->render($vars);
    //     } catch (\Throwable $e) {
    //         return "Error {$e->getCode()}: {$e->getMessage()}";
    //     }
    // }

    // public function renderError(string $message, int $code = 0): string {
    //     $errorName = "Ошибка " ;
    //     //. ($code > 0 ? "$code" : "");
    //     //$canonical = "/error" ;
    //     //. ($code > 0 ? "$code" : "");
    //     return $this->renderPage('classnotfound.twig', ['error_name' => $errorName, 'error_message' => $message]);
    // }
}