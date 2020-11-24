<?php

namespace App\Jobs\Reports;

use App\Zen\Report\Model\ReportLibraryBackground;
use App\Zen\Report\Model\ReportLibraryRepository;
use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class ReportLibraryJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;
    /**
     * @var ReportLibraryBackground
     */
    protected $reportLibrary;

    /**
     * ReportLibraryJob constructor.
     * @param int $website_id
     * @param ReportLibraryBackground $reportLibrary
     */
    public function __construct(ReportLibraryBackground $reportLibrary)
    {
        $this -> reportLibrary = $reportLibrary;
    }


    /**
     * @throws \Illuminate\Contracts\Container\BindingResolutionException
     */
    public function handle()
    {
        Auth ::loginUsingId($this -> reportLibrary -> user_id);

        $this -> setLanguageforReportLibrary();

        if(auth() -> user() -> email == config('queue_user_email')) {
            try {
                $this -> reportLibrary -> start_time = now();
                $this -> reportLibrary -> attempts = 1;
                $this -> reportLibrary -> save();
                (new ReportLibraryRepository) -> overrideDates($this -> reportLibrary -> start_date, $this -> reportLibrary -> end_date) -> makeReport(json_decode($this -> reportLibrary -> report_libraries), $this -> reportLibrary -> file_format);
                $this -> reportLibrary -> done = 1;
                $this -> reportLibrary -> end_time = now();
                $this -> reportLibrary -> save();
            } catch (\Exception $exception) {
                Log ::critical($exception -> getMessage());
            }
        } else {
            Log ::critical('The user email didn\'t match');
        }
        Auth ::logout();
    }

    public function overrideDates($startDate = null, $endDate = null)
    {
        if($startDate)
            request() -> start_date_new = $startDate;

        if($endDate)
            request() -> end_date_new = $endDate;

        return $this;
    }

    private function setLanguageforReportLibrary(): void
    {
        if(auth() -> check())
            app() -> setLocale(auth() -> user() -> locale);
    }
}
