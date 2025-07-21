<?php

namespace Modules\Settings\Repositories;

use Carbon\Carbon;
use Exception;
use Modules\Core\Console\DurrbarVerification;
use Modules\Core\Repositories\BaseRepository;
use Modules\Settings\Models\Settings;

class SettingsRepository extends BaseRepository
{
    /**
     * Configure the Model
     **/
    public function model()
    {
        return Settings::class;
    }

    public function getApplicationSettings(): array
    {
        $appData = $this->getAppSettingsData();

        return [
            'app_settings' => $appData,
        ];
    }

    private function getAppSettingsData(): array
    {
        $config = new DurrbarVerification();
        $apiData = $config->jsonSerialize();
        try {
            $licenseKey = $config->getPrivateKey();
            $last_checking_time = $config->getLastCheckingTime() ?? Carbon::now();
            $lastCheckingTimeDifferenceFromNow = Carbon::parse($last_checking_time)->diffInMinutes(Carbon::now());
            if ($lastCheckingTimeDifferenceFromNow > 20) {
                $apiData = $config->verify($licenseKey)->jsonSerialize();
            }
        } catch (Exception $e) {
        }

        return [
            'last_checking_time' => Carbon::now(),
            'trust' => $apiData['trust'] ?? false,
        ];
    }
}
