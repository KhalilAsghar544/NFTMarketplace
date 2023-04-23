<?php

namespace App\Console\Commands;

use App\Model\Category;
use App\Model\CategoryTranslation;
use App\Model\Content;
use App\Model\ContentTranslation;
use App\Model\Faq;
use App\Model\FaqHead;
use App\Model\FaqHeadTranslation;
use App\Model\FaqTranslation;
use App\Model\Language;
use App\Model\News;
use App\Model\NewsTranslation;
use App\Model\Setting;
use App\Model\Slider;
use App\Model\SliderTranslation;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;

class UpdateVersion extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'update:version';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Update application version';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        DB::beginTransaction();
        try {
            $allsetting = allsetting();
            if(!isset($allsetting['version'])) {
                Setting::create(['slug' => 'version', 'value' => 2]);
            }
            if(allsetting('version') < config('app.version')) {
                Setting::where('slug', 'version')->update(['value' => config('app.version')]);
            }

            $message = 'Successfully migrated to NFTZai v2';
            DB::commit();
        }catch (\Exception $e) {
            DB::rollBack();
            $message = $e->getMessage();
        }
        $this->info($message);

    }
}
