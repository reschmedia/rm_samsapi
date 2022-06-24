<?php
declare(strict_types=1);
namespace Reschmedia\RmSamsApi\Api;

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
use Reschmedia\RmSamsApi\Domain\Repository\SamsRepository;

/**
 * SamsApi
 */
class SamsApi implements SingletonInterface
{

    /**
     * Sams Repository
     * 
     * @var SamsRepository
     */
    protected $samsRepository = null;

    /**
     * API Key
     * 
     * @var string
     */
    protected $apiKey = '';

    /**
     * Object Constructor
     */
    public function __construct(SamsRepository $samsRepository)
    {
        $this->samsRepository = $samsRepository;
    }

    /**
     * Get committee by uuid
     * 
     * @param string $uuid
     * @return \stdClass
     */
    public function committee(string $uuid): \stdClass
    {
        return $this->samsRepository->getCommittee($uuid) ? new stdClass();
    }

    /**
     * Get all committees
     * 
     * @return array
     */
    public function committees(): array
    {
        return $this->samsRepository->getCommittees();
    }

    /**
     * Get league by uuid
     * 
     * @param string $uuid
     * @return \stdClass
     */
    public function league(string $uuid): \stdClass
    {
        return $this->samsRepository->getLeague($uuid);
    }
}