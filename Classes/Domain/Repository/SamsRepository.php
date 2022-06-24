<?php
declare(strict_types=1);
namespace Reschmedia\RmSamsApi\Domain\Repository;

/***
 *
 * This file is part of the "Sams API" Extension for TYPO3 CMS.
 *
 * For the full copyright and license information, please read the
 * LICENSE.txt file that was distributed with this source code.
 *
 *  (c) 2022 Rene Schoenfeld <r.schoenfeld@resch-media.de>, resch media
 *
 ***/

use TYPO3\CMS\Core\SingletonInterface;
use TYPO3\CMS\Core\Utility\GeneralUtility;
use TYPO3\CMS\Core\Http\RequestFactory;
use TYPO3\CMS\Extbase\Configuration\ConfigurationManager;
use TYPO3\CMS\Extbase\Configuration\ConfigurationManagerInterface;

/**
 * SamsRepository
 */
class SamsRepository implements SingletonInterface
{
    /**
     * Request Factory
     * 
     * @var RequestFactory
     */
    protected $requestFactory = null;

    /**
     * Settings
     * 
     * @var array
     */
    protected $settings = [];

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->requestFactory = GeneralUtility::makeInstance(RequestFactory::class);
        // $this->apiKey = $GLOBALS['TSFE']->tmpl->setup['plugin.']['tx_rmsamsapi.']['settings.']['apiKey'];

        $this->configurationManager = GeneralUtility::makeInstance(ConfigurationManager::class);
        $tsConfig = $this->configurationManager->getConfiguration(
            ConfigurationManagerInterface::CONFIGURATION_TYPE_FULL_TYPOSCRIPT
        );
        $this->settings = $tsConfig['plugin.']['tx_rmsamsapi.']['settings.'];
    }

    /**
     * Finds the given address
     * 
     * @param string $uuid
     * @return \stdClass
     */
    public function getCommittee(string $uuid): \stdClass
    {   
        $options = [
            'headers' => ['x-api-key' => $this->settings['apiKey']],
        ];
        $response = $this->requestFactory->request('https://dvv.sams-server.de/api/v2/committees/' . $uuid, 'GET', $options);
        $statusCode = $response->getStatusCode();

        $committee = json_decode($response->getBody()->getContents());

        return $committee;
    }

    /**
     * Finds the given address
     * 
     * @param string $uuid
     * @return array
     */
    public function getCommittees(): array
    {   
        $options = [
            'headers' => ['x-api-key' => $this->settings['apiKey']],
        ];
        $response = $this->requestFactory->request('https://dvv.sams-server.de/api/v2/committees?size=100', 'GET', $options);
        $statusCode = $response->getStatusCode();

        $committees = json_decode($response->getBody()->getContents());
        if ($committees->numberOfelements != $committees->totalElements) {
            # code...
        }

        return $committees->content;
    }

    /**
     * Finds the given address
     * 
     * @param string $uuid
     * @return \stdClass
     */
    public function getLeague(string $uuid): \stdClass
    {   
        $response = $this->requestFactory->request('https://apihub.sams-server.de/'.$this->settings['token'] . '/get/' . $uuid, 'GET');
        $statusCode = $response->getStatusCode();

        $league = json_decode($response->getBody()->getContents());

        return $league;
    }
}