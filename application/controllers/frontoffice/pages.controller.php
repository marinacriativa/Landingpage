<?php 

/** 
* Controller main ( Backoffice ) 
*
*   Extends: core/Controller.php
*   Author: Vlad
**/

namespace Fyre\Controller;

class pages extends \Fyre\Core\Controller {

    function page_by_url($url) {
        global $app;

        $this->dependencies(array("pages"), array());
        
        $lang = $app->select_language;        
        
        if(isset($_COOKIE['lang'])) { 
            $lang = $_COOKIE['lang'];
        }

        if(isset($_GET['iframe'])) {
            $lang = $_GET['iframe'];
        }

        $pages = $this->dependencies->pages->url($url, 2, $lang);

        if($pages != false) {
            // conteudo da pagina a partir da database        // 
            $content_html = $pages->content;
            
            $title = $pages->name;
    
            $html = $this->template("pages/pages", array("title" => $title, "content_html" => $content_html));
        } else {
            $html = $this->template("pages/pages", array("title" => 'Não encontrado', "content_html" => 'Nenhum conteúdo a ser exibido.'));
        }

        echo $html;
    }
    
    function index() {

        global $app;

        $website_config = $app->config; 

        // Dependencies
        $this->dependencies(array( "constructions", "categories_constructions",  "news", "testimonies"), array());


        // Obter as constructions
        $constructions = $this->dependencies->constructions->multiple($app->select_language);

        // Obter categorias de construções
        $categories_constructions   = $this->dependencies->categories_constructions->multiple();

        // Obter notícias em destaque
        $news = $this->dependencies->news->getFeatured($app->select_language);

        $testimonies = $this->dependencies->testimonies->listing($app->selected_language);
        
        echo $this->template("pages/main", compact("news", "testimonies", "website_config"));
    }

    function redirect_language() {

        global $app;

        $app->redirect("/" . $app->selected_language->code);
    }

    function profile() {
        
        global $app;
        
        echo $this->template("pages/profile");
    }
    
    function faq() {
        
        global $app;

        // Dependencies
        $this->dependencies(array("faqs"), array());

        // Obter os faqs
        $faqs = $this->dependencies->faqs->byLang($app->select_language);

        echo $this->template("pages/faq", compact("faqs"));
    }

    function product() {
        
        echo $this->template("pages/product");
    }

    function construction() {
        
        echo $this->template("pages/construction");
    }
    
    function privacy() {
        
        echo $this->template("pages/privacy");
    }

    function terms() {
        
        echo $this->template("pages/terms");
    }

    function items() {

        echo $this->template("pages/items");
    }

    function consult_form() {

        echo $this->template("pages/consult_form");
    }
    
    function services() {

        echo $this->template("pages/services");
    }

    function brands() {

        global $app;
        
        // Dependencies
        $this->dependencies(array("brands"));

        // Obter as marcas agentes
        $brandsAgents = $this->dependencies->brands->getAgentsGroup();

        // Obter as marcas agentes
        $brandsNoAgents = $this->dependencies->brands->getNoAgentsGroup();     

        echo $this->template("pages/brands", compact('brandsAgents', 'brandsNoAgents'));
    }      

    function imported_datas() {

        global $app;
        
        // Dependencies
        $this->dependencies(array("imported_datas"));

        // Obter datas
        $imported_datas = $this->dependencies->imported_datas->multiple();

        echo $this->template("pages/imported_datas", compact("imported_datas"));
    }

    function course() {

        echo $this->template("pages/course");
    }

    function testimonials() {

        global $app;
    
        // Dependencies
        $this->dependencies(array("testimonies"), array());
    
        /* TODO PAGINAÇÃO */
        $testimonies = $this->dependencies->testimonies->listing($app->selected_language);
    
        echo $this->template("pages/testimonials", compact("testimonies"));
    }

    function about() {

        global $app;
        
        // Dependencies
        $this->dependencies(array("faqs", "custom_page"), array());

        // Obter os faqs
        $faqs = $this->dependencies->faqs->byLang($app->select_language);

        $custom_page = $this->dependencies->custom_page->singleLang($app->select_language);

        echo $this->template("pages/about", compact("faqs", "custom_page"));
    }
    
    function booking() {

        global $app;
            
        $website_config = $app->config; 

        echo $this->template("pages/booking", compact('website_config'));
    }
    
    function change_language($id) {
        
        global $app;

        setcookie("lang", str_replace("/language/", "", $app->curent_url), time() + (10 * 365 * 24 * 60 * 60), "/");
        header('Location: ' . $_SERVER['HTTP_REFERER']);
    }
    
    function newsletter() {
    
        global $app;
        
        // Dependencies
        $this->dependencies(array("newsletter", "products", "schedule", "homepages", "banners"));

        // Obter os banners
        $banners = $this->dependencies->banners->list($app->select_language);

        // Obter produtos em destaque
        $products = $this->dependencies->products->getFeatured($app->select_language);

        $homepages = $this->dependencies->homepages->listing();

        $schedule = $this->dependencies->schedule->getFeatured($app->select_language);

        $email = $_POST["email"];
        $errorMessage = null;
        $successMessage = null;

        if (filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $existEmail = $this->dependencies->newsletter->newsletterByEmail($_POST["email"]);
            if ($existEmail == false){
                if ($app->auth->isLogged()) {

                    $user_data      = $app->auth->getUser($app->auth->getSessionUID($app->auth->getCurrentSessionHash()));
                    $_POST["name"]  = $user_data["name"];
                }

                $_POST["ip"] = $this->get_client_ip();
                $_POST["lang"] = $app->selected_language->code;

                $status = $this->dependencies->newsletter->insert($_POST);

                if ($status["success"]) {
                    $successMessage = "Email registado nas newletter com sucesso";
                    echo $this->template("pages/main", compact("successMessage", "schedule", "homepages", 'popups', "banners", "products"));

                }
            }else{
                $errorMessage = "Este email já se encontra registado para receber newsletter";
                echo $this->template("pages/main", compact("errorMessage", "schedule", "homepages", "banners", 'popups', "products"));
            }
        }else{
            $errorMessage = "$email, este email não é valido. Exemplo: abc@gmail.com";
            echo $this->template("pages/main", compact("errorMessage", "schedule", "homepages", "banners", 'popups', "products"));
        }
    }
}