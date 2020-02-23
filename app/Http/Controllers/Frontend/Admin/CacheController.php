<?php


namespace App\Http\Controllers\Frontend\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Contracts\Console\Kernel;
use Illuminate\Support\Facades\Artisan;

/**
 * Class CacheController
 *
 * @package \App\Http\Controllers\Frontend\Admin
 */
class CacheController  extends Controller
{
    /**
     * @var \Illuminate\Contracts\Console\Kernel
     */
    private $artisan;

    public function __construct(Kernel $artisan)
    {
        $this->artisan = $artisan;
    }

    public function clear()
    {
      self::flush();

      return redirect('/');
    }

    public static function flush()
    {
       Artisan::call('cache:clear');
       Artisan::call('cache:clear');
       Artisan::call('config:clear');
       Artisan::call('view:clear');
    }

    public static function empty()
    {
        self::flush();
    }
}
