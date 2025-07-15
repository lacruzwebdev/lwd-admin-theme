<?php

/*
Plugin Name: LWD Admin Theme
Plugin URI: https://lacruzwebdev.com
Description: Un tema moderno y elegante para el panel de administración de WordPress.
Author: Lacruzwebdev
Version: 1.0.0
Author URI: https://lacruzwebdev.com/
*/

// Evitar acceso directo


if (!defined('ABSPATH')) {
  exit;
}

class LWDAdminTheme
{

  public function __construct()
  {
    add_action('admin_enqueue_scripts', array($this, 'enqueue_admin_styles'));
    add_action('login_enqueue_scripts', array($this, 'enqueue_admin_styles'));
    add_filter('admin_footer_text', array($this, 'custom_admin_footer'));
    add_filter('login_headerurl', function ($url): string {
      return '/';
    });

    add_action('login_header', function () {
      echo '<div id="login-wrapper">';
      echo '<div id="login-panel">';
    });

    add_action('login_footer', function () {
      echo '</div><div id="login-background"></div>';
      echo '</div>';
    });

    add_action('login_enqueue_scripts', function (): void {
      wp_enqueue_style('lwd-login', plugins_url('css/lwd-login.css', __FILE__), array(), '1.0.0');
    }, 100);

    add_action('login_enqueue_scripts', function () {
      $logoOptions = get_field('logo', 'option');
      $logo = $logoOptions ? $logoOptions['url'] : asset('resources/images/logo.svg');

      if ($logo) {
        $logo_url = $logo;
        echo '<style type="text/css">';
        echo 'body.login #login h1 a {';
        echo 'background-image: url(' . esc_url($logo_url) . ');';
        echo '}';
        echo '</style>';
      }
    });
  }

  public function enqueue_admin_styles()
  {
    // Cargar solo el archivo CSS unificado
    wp_enqueue_style(
      'lwd-admin-theme',
      plugins_url('css/lwd-admin-theme.css', __FILE__),
      array(),
      '1.0.0'
    );
  }

  public function custom_admin_footer($text)
  {
    return 'Desarrollado por <a href="https://lacruzwebdev.com" target="_blank">Lacruzwebdev</a>';
  }
}

// Inicializar el plugin
new LWDAdminTheme();