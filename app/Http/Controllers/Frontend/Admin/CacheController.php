<?php


namespace App\Http\Controllers\Frontend\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Contracts\Console\Kernel;

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
      $this->artisan->call('cache:clear');
      $this->artisan->call('config:clear');
      $this->artisan->call('view:clear');

      return redirect()->back()->with(['success' => 'Der Cache wurde erfolgreich geleert']);
  }
}
