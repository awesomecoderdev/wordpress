<?php


/**
 * The main template file.
 *
 * This is the most generic template file in a WordPress theme
 * and one of the two required files for a theme (the other being style.css).
 * It is used to display a page when nothing more specific matches a query.
 * E.g., it puts together the home page when no home.php file exists.
 *
 * @link https://codex.wordpress.org/Template_Hierarchy
 *
 * @link              https://awesomecoder.dev/
 * @since             1.0.0
 * @package           lumi
 *
 */

use Google\Service\Oauth2;
use AwesomeCoder\Lumi\Hooks\Authorization;

if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly.
}

?>

<?php get_header(); ?>


<main id="main" class="<?php echo lumi_container("py-10 not-prose"); ?>">

    <div class="relative grid xl:grid-cols-10 md:grid-cols-10 gap-10">
        <div class="relative md:col-span-5 col-span-1 max-sm:hidden">
            <div class="relative max-w-sm mx-auto flex flex-col justify-end bg-gray-200 overflow-hidden bg-img-cover bg-center bg-no-repeat rounded-xl h-full w-full aspect-[4/3]" style="background: url(<?php echo url("img/auth/banner.png") ?>);">
                <div class="relative p-4 py-6 text-white">
                    <h2 class=" text-3xl font-semibold"><?php _e("Welcome to Lumi", "lumi"); ?></h2>
                    <p class="lead text-base font-medium"><?php _e("Luxury shopping without limits.", "lumi") ?></p>
                    <div class="relative flex items-center gap-2 pt-2">
                        <span class="h-3 w-3 rounded-full bg-slate-50"></span>
                        <span class="h-3 w-3 rounded-full bg-slate-50"></span>
                        <span class="h-4 w-4 rounded-full bg-primary-500 border-white border-2"></span>
                    </div>
                </div>
            </div>
        </div>
        <div class="relative md:col-span-5  col-span-1 space-y-5">
            <h1 class="text-3xl font-semibold"><?php _e("Sign In to Lumi", "lumi") ?></h1>
            <form id="login-form" action="javascript:void(0)" method="POST" class="relative space-y-3 max-w-sm">
                <div class="relative grid">
                    <label for="email"><?php _e("Email Address", "lumi") ?></label>
                    <div class="relative border border-primary-50 rounded-lg">
                        <div class="absolute pointer-events-none z-50 left-2 top-1/2 transform translate-y-[-50%] w-20">
                            <div class="relative h-full w-full flex items-center text-primary-500 space-x-2">
                                <svg class="h-6 w-6" width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                    <path d="M19.875 4.5H4.125C3.08947 4.5 2.25 5.33947 2.25 6.375V17.625C2.25 18.6605 3.08947 19.5 4.125 19.5H19.875C20.9105 19.5 21.75 18.6605 21.75 17.625V6.375C21.75 5.33947 20.9105 4.5 19.875 4.5Z" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" />
                                    <path d="M5.25 7.5L12 12.75L18.75 7.5" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" />
                                </svg>
                                <span class="h-6 w-[0.95px] bg-primary-400 block"></span>
                            </div>
                        </div>
                        <input class="relative pl-14 text-sm placeholder:text-sm bg-transparent outline-none border-none border-transparent outline-transparent focus:outline-none focus-visible:outline-none focus:ring-transparent w-full" type="email" name="email" id="email" placeholder="Enter your email">
                    </div>
                </div>
                <div class="relative grid">
                    <label for="password"><?php _e("Password", "lumi") ?></label>
                    <a class="text-red-600 absolute right-2 text-xs " href="<?php echo site_url("/my-account/lost-password") ?>"><?php _e("Forget password ?", "lumi") ?></a>
                    <div class="relative border border-primary-50 rounded-lg">
                        <div class="absolute pointer-events-none z-50 left-2 top-1/2 transform translate-y-[-50%] w-20">
                            <div class="relative h-full w-full flex items-center text-primary-500 space-x-2">
                                <svg class="h-6 w-6" width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                    <path d="M15.75 9.75V5.29688C15.75 4.30231 15.3549 3.34849 14.6517 2.64522C13.9484 1.94196 12.9946 1.54688 12 1.54688C11.0054 1.54688 10.0516 1.94196 9.34835 2.64522C8.64509 3.34849 8.25 4.30231 8.25 5.29688V9.75" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" />
                                    <path d="M17.25 9.75H6.75C5.50736 9.75 4.5 10.7574 4.5 12V20.25C4.5 21.4926 5.50736 22.5 6.75 22.5H17.25C18.4926 22.5 19.5 21.4926 19.5 20.25V12C19.5 10.7574 18.4926 9.75 17.25 9.75Z" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" />
                                </svg>

                                <span class="h-6 w-[0.95px] bg-primary-400 block"></span>
                            </div>
                        </div>
                        <input class="relative pl-14 text-sm placeholder:text-sm bg-transparent outline-none border-none border-transparent outline-transparent focus:outline-none focus-visible:outline-none focus:ring-transparent w-full" type="password" name="password" id="password" placeholder="Enter your password">

                        <svg id="password-show" class="hidden password-integrator absolute text-slate-500 cursor-pointer right-2 top-1/2 transform translate-y-[-50%] w-5 h-5" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M2.036 12.322a1.012 1.012 0 010-.639C3.423 7.51 7.36 4.5 12 4.5c4.638 0 8.573 3.007 9.963 7.178.07.207.07.431 0 .639C20.577 16.49 16.64 19.5 12 19.5c-4.638 0-8.573-3.007-9.963-7.178z" />
                            <path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                        </svg>
                        <svg id="password-hidden" class="password-integrator absolute text-slate-500 cursor-pointer right-2 top-1/2 transform translate-y-[-50%] w-5 h-5" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M3.98 8.223A10.477 10.477 0 001.934 12C3.226 16.338 7.244 19.5 12 19.5c.993 0 1.953-.138 2.863-.395M6.228 6.228A10.45 10.45 0 0112 4.5c4.756 0 8.773 3.162 10.065 7.498a10.523 10.523 0 01-4.293 5.774M6.228 6.228L3 3m3.228 3.228l3.65 3.65m7.894 7.894L21 21m-3.228-3.228l-3.65-3.65m0 0a3 3 0 10-4.243-4.243m4.242 4.242L9.88 9.88" />
                        </svg>
                    </div>
                </div>
                <div class="flex items-center py-2">
                    <input id="rememberme" type="checkbox" name="rememberme" value="forever" class="cursor-pointer w-4 h-4 text-primary-600 bg-gray-100 border-gray-300 rounded focus:ring-primary-500 dark:focus:ring-primary-600 dark:ring-offset-gray-800 dark:focus:ring-offset-gray-800 focus:ring-2 dark:bg-gray-700 dark:border-gray-600">
                    <label for="rememberme" class="cursor-pointer ml-2 text-sm font-medium text-slate-600 dark:text-gray-300"><?php _e('Keep me signed in.', 'lumi') ?></label>
                </div>

                <div class="relative w-full">
                    <button class="mx-auto block bg-primary-500 text-white w-full rounded-md overflow-hidden py-1" type="submit">Sign In</button>
                    <p class="text-center py-2 text-slate-600"><?php _e('Don’t have an account yet? ', 'lumi') ?> <a class="text-primary-500" href="<?php echo site_url("/register") ?>"><?php _e('Sign Up now', 'lumi') ?></a></p>
                </div>


                <div class="relative space-y-4">
                    <div class="flex items-center gap-3">
                        <span class="h-[0.5px] bg-primary-400 w-full"></span>
                        <span><?php _e('or', 'lumi') ?></span>
                        <span class="h-[0.5px] bg-primary-400 w-full"></span>
                    </div>
                    <a class="flex items-center justify-center gap-2 border rounded-lg p-2" href="<?php echo (new Authorization())->getOauthLoginUrl() ?>">
                        <svg class="h-6 w-6" viewBox="-0.5 0 48 48" version="1.1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" fill="#000000">
                            <g id="SVGRepo_bgCarrier" stroke-width="0"></g>
                            <g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g>
                            <g id="SVGRepo_iconCarrier">
                                <title>Google-color</title>
                                <desc>Created with Sketch.</desc>
                                <defs> </defs>
                                <g id="Icons" stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
                                    <g id="Color-" transform="translate(-401.000000, -860.000000)">
                                        <g id="Google" transform="translate(401.000000, 860.000000)">
                                            <path d="M9.82727273,24 C9.82727273,22.4757333 10.0804318,21.0144 10.5322727,19.6437333 L2.62345455,13.6042667 C1.08206818,16.7338667 0.213636364,20.2602667 0.213636364,24 C0.213636364,27.7365333 1.081,31.2608 2.62025,34.3882667 L10.5247955,28.3370667 C10.0772273,26.9728 9.82727273,25.5168 9.82727273,24" id="Fill-1" fill="#FBBC05"> </path>
                                            <path d="M23.7136364,10.1333333 C27.025,10.1333333 30.0159091,11.3066667 32.3659091,13.2266667 L39.2022727,6.4 C35.0363636,2.77333333 29.6954545,0.533333333 23.7136364,0.533333333 C14.4268636,0.533333333 6.44540909,5.84426667 2.62345455,13.6042667 L10.5322727,19.6437333 C12.3545909,14.112 17.5491591,10.1333333 23.7136364,10.1333333" id="Fill-2" fill="#EB4335"> </path>
                                            <path d="M23.7136364,37.8666667 C17.5491591,37.8666667 12.3545909,33.888 10.5322727,28.3562667 L2.62345455,34.3946667 C6.44540909,42.1557333 14.4268636,47.4666667 23.7136364,47.4666667 C29.4455,47.4666667 34.9177955,45.4314667 39.0249545,41.6181333 L31.5177727,35.8144 C29.3995682,37.1488 26.7323182,37.8666667 23.7136364,37.8666667" id="Fill-3" fill="#34A853"> </path>
                                            <path d="M46.1454545,24 C46.1454545,22.6133333 45.9318182,21.12 45.6113636,19.7333333 L23.7136364,19.7333333 L23.7136364,28.8 L36.3181818,28.8 C35.6879545,31.8912 33.9724545,34.2677333 31.5177727,35.8144 L39.0249545,41.6181333 C43.3393409,37.6138667 46.1454545,31.6490667 46.1454545,24" id="Fill-4" fill="#4285F4"> </path>
                                        </g>
                                    </g>
                                </g>
                            </g>
                        </svg>
                        <span class="text-slate-600 text-sm font-normal">
                            <?php _e('Continue with Google', 'lumi'); ?>
                        </span>
                    </a>
                </div>

            </form>
        </div>
    </div>
</main>


<?php get_footer(); ?>