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
        $ts_config = $this->configurationManager->getConfiguration(
            ConfigurationManagerInterface::CONFIGURATION_TYPE_FULL_TYPOSCRIPT
        );
        $this->settings = $ts_config['plugin.']['tx_rmsamsapi.']['settings.'];
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

        if ($committee == null) {
            $committee = new stdClass();
        }
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


        if ($league == null) {
            $league = new stdClass();
        }
        return $league;
    }

    /**
     * Finds the given address
     * 
     * @return array
     */
    public function getLeagues(): array
    {   
        $response = $this->requestFactory->request('https://apihub.sams-server.de/'.$this->settings['token'] . '/get/SamsDvv/season');
        $statusCode = $response->getStatusCode();

        $leagues = json_decode($response->getBody()->getContents());
        $leagues = $leagues;

        return $leagues;
    }

    /**
     * Finds the given address
     * 
     * @param string $uuid
     * @return array
     */
    public function getEvents(string $uuid): array
    {   
        $options = [
            'headers' => ['x-api-key' => $this->settings['apiKey']],
        ];
        $response = $this->requestFactory->request('https://dvv.sams-server.de/api/v2/events?size=100', 'GET', $options);
        $statusCode = $response->getStatusCode();

        $events = [];

        if ($uuid != '') {
            foreach (json_decode($response->getBody()->getContents())->content as $event) {
                if ($event->eventTypeUuid == $uuid) {
                    $events[] = $event;
                }
            }
        } else {
            $events = json_decode($response->getBody()->getContents())->content;
        }
        
        return $events;
    }

    /**
     * Finds the given address
     * 
     * @return array
     */
    public function getEventtypes(): array
    {   
        $options = [
            'headers' => ['x-api-key' => $this->settings['apiKey']],
        ];
        $response = $this->requestFactory->request('https://dvv.sams-server.de/api/v2/eventtypes', 'GET', $options);
        $statusCode = $response->getStatusCode();

        $eventtypes = json_decode($response->getBody()->getContents());
        if ($eventtypes->numberOfelements != $eventtypes->totalElements) {
            # code...
        }

        return $eventtypes;
    }

}