<?php
/**
 * Created by PhpStorm.
 * User: sohrab
 * Date: 2018-11-03
 * Time: 11:42
 */

namespace App\Classes\Report;


use Google_Service_AnalyticsReporting;
use Google_Service_AnalyticsReporting_DateRange;
use Google_Service_AnalyticsReporting_Dimension;
use Google_Service_AnalyticsReporting_GetReportsRequest;
use Google_Service_AnalyticsReporting_Metric;
use Google_Service_AnalyticsReporting_OrderBy;
use Google_Service_AnalyticsReporting_ReportRequest;
use Google_Service_AnalyticsReporting_SegmentDimensionFilter;

abstract class GaReport implements ReportInterface
{
    /**
     * @var Google_Service_AnalyticsReporting_DateRange
     */
    protected $dateRange;

    /**
     * @var Google_Service_AnalyticsReporting_Metric[]
     */
    protected $metrics;
    /**
     * @var Google_Service_AnalyticsReporting_Dimension
     */
    protected $dimension;
    /**
     * @var Google_Service_AnalyticsReporting_OrderBy
     */
    protected $orderBy;
    /**
     * @var Google_Service_AnalyticsReporting_SegmentDimensionFilter
     */
    protected $filter;
    /**
     * @var Google_Service_AnalyticsReporting_ReportRequest
     */
    protected $request;
    /**
     * @var Google_Service_AnalyticsReporting_GetReportsRequest
     */
    protected $body;
    /**
     * @var Google_Service_AnalyticsReporting
     */
    protected $analytics;

    public function __construct(Google_Service_AnalyticsReporting $analytics,
                                Google_Service_AnalyticsReporting_GetReportsRequest $body,
                                Google_Service_AnalyticsReporting_ReportRequest $request,
                                Google_Service_AnalyticsReporting_DateRange $dateRange,
                                Google_Service_AnalyticsReporting_Metric $metric,
                                Google_Service_AnalyticsReporting_Dimension $dimension,
                                Google_Service_AnalyticsReporting_OrderBy $orderBy,
                                Google_Service_AnalyticsReporting_SegmentDimensionFilter $filter)
    {
        $this->dateRange = $dateRange;
        $this->metrics[0] = $metric;
        $this->metrics[1] = $metric;
        $this->dimension = $dimension;
        $this->orderBy = $orderBy;
        $this->filter = $filter;
        $this->request = $request;
        $this->body = $body;
        $this->analytics = $analytics;
    }

    protected function get()
    {
        $this->body->setReportRequests([$this->request]);
        return $this->analytics->reports->batchGet($this->body);
    }

    public abstract function getReport($path, $from = '2013-01-01', $to = 'today');

    /**
     * @param $from
     * @param $to
     */
    protected function setDataRange($from, $to): void
    {
        // Init the DateRange object
        $this->dateRange->setStartDate($from);
        $this->dateRange->setEndDate($to);
    }

    protected function setRequest(): void
    {
        $this->request->setDateRanges($this->dateRange);
        $this->request->setMetrics($this->metrics);
        $this->request->setDimensions($this->dimension);
        $this->request->setOrderBys($this->orderBy);
        $this->request->setDimensionFilterClauses($this->filter);
    }

    protected abstract function setMetrics(): void;

    protected abstract function setDimension(): void;

    protected abstract function setOrderBy(): void;

    protected abstract function setDimensionFilter($value): void;

    /**
     * @param $path
     * @param $from
     * @param $to
     */
    protected function init($path, $from, $to): void
    {
        $this->setDataRange($from, $to);
        $this->setMetrics();
        $this->setDimension();
        $this->setOrderBy();
        $this->setDimensionFilter($path);
        $this->setRequest();
    }
}