<?php

namespace Nabil\MVC\app;

class Router
{
    /**
     * @var array $routes
     * Menyimpan semua rute yang didaftarkan lewat Router::add().
     * Struktur setiap item:
     * [
     *   'method'     => 'GET'|'POST'|...,
     *   'path'       => '/users/(\d+)',     // boleh plain string atau regex-friendly (pakai capture group)
     *   'controller' => ControllerClass::class,
     *   'function'   => 'methodName',
     *   'middleware' => [MiddlewareClassA::class, MiddlewareClassB::class, ...]
     * ]
     */
    private static array $routes = [];

    /**
     * Mendaftarkan route baru.
     *
     * @param string $method      HTTP method (GET/POST/PUT/DELETE, dll).
     * @param string $path        Pola path. Mendukung regex karena nanti akan dibungkus dengan #^...$#.
     *                            Contoh: '/user/(\d+)' untuk menangkap ID numerik.
     * @param string $controller  Nama kelas controller (FQCN).
     * @param string $function    Nama method di controller yang dipanggil.
     * @param array  $middlewares Daftar kelas middleware (opsional). Setiap middleware wajib punya method before().
     *
     * @return void
     */
    public static function add(
        string $method,
        string $path,
        string $controller,
        string $function,
        array  $middlewares = []
    ): void {
        // Simpan definisi rute ke dalam array statis $routes
        self::$routes[] = [
            'method' => $method,
            'path' => $path,
            'controller' => $controller,
            'function' => $function,
            'middleware' => $middlewares
        ];
    }

    /**
     * Menjalankan router:
     * - Baca path & method dari superglobal $_SERVER
     * - Loop semua rute dan cari yang cocok dengan path + method
     * - Jalankan middleware berurutan
     * - Panggil controller::function dengan parameter hasil tangkapan regex (jika ada)
     */
    public static function run(): void
    {
        // Default path adalah '/' jika PATH_INFO tidak diset (misalnya akses ke root)
        $path = '/';
        if (isset($_SERVER['PATH_INFO'])) {
            // PATH_INFO biasanya berisi path setelah domain dan index.php (tergantung konfigurasi server)
            $path = $_SERVER['PATH_INFO'];
        }

        // HTTP method dari request, misal: GET, POST, PUT, DELETE
        $method = $_SERVER['REQUEST_METHOD'];

        // Telusuri semua rute yang sudah didaftarkan
        foreach (self::$routes as $route) {
            /**
             * $route['path'] akan diperlakukan sebagai pola regex.
             * Kita bungkus dengan delimiters "#^" dan "$#" supaya:
             * - ^ menandakan awal string, $ menandakan akhir string (match harus full, bukan sebagian).
             * - Contoh: jika path '/user/(\d+)', maka URL '/user/42' akan match dan menangkap '42'.
             * - awal dan akhir tidak menggunakan '/' karena '/' banyak digunakan di URL 
             * 
             */
            $pattern = "#^" . $route['path'] . "$#";

            /**
             * preg_match($pattern, $path, $variables)
             * - Menguji apakah $path cocok dengan pola $pattern.
             * - Jika cocok: $variables[0] = match penuh, $variables[1..n] = hasil capture group.
             * - Sekaligus cek method harus sama (GET vs POST, dll).
             */
            if (preg_match($pattern, $path, $variables) && $method == $route['method']) {

                // --- Jalankan semua middleware sebelum controller ---
                // Konvensi: setiap middleware adalah kelas dengan method ->before()
                foreach ($route['middleware'] as $middleware) {
                    $instance = new $middleware; // instansiasi kelas middleware
                    $instance->before();         // jalankan hook sebelum controller
                }

                // Siapkan nama method controller yang akan dipanggil
                $function = $route['function'];

                // Buat instance controller
                $controller = new $route['controller'];

                // $variables berisi [match_penuh, capture1, capture2, ...]
                // array_shift menghapus elemen pertama (match penuh) sehingga tersisa hanya parameter yang ditangkap.
                array_shift($variables);

                /**
                 * Panggil method controller dengan parameter dinamis (jika ada) dari $variables.
                 * call_user_func_array([obj, 'method'], $args) memanggil $obj->method(...$args)
                 * Contoh:
                 *   path '/user/(\d+)' dengan URL '/user/42' => $variables = ['42']
                 *   maka kita memanggil $controller->$function('42')
                 */
                call_user_func_array([$controller, $function], $variables);

                // Setelah menemukan rute yang cocok dan dieksekusi, hentikan proses run()
                return;
            }
        }

        // Jika tidak ada rute yang cocok: kirim status 404 dan tampilkan pesan default.
        http_response_code(404);
        echo 'CONTROLLER NOT FOUND';
    }
}

/**
 * --- CONTOH PENGGUNAAN (opsional) ---
 *
 * Router::add('GET',  '/',        HomeController::class, 'index');
 * Router::add('GET',  '/user/(\d+)', UserController::class, 'show'); // akan panggil show($id)
 * Router::add('POST', '/login',   AuthController::class, 'login', [CsrfMiddleware::class]);
 *
 * Lalu di front controller (public/index.php):
 * require_once '../vendor/autoload.php';
 * use Nabil\MVC\app\Router;
 * // register semua route...
 * Router::run();
 */
