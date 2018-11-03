<?php
/**
 * Created by PhpStorm.
 * User: sohrab
 * Date: 2018-11-03
 * Time: 12:54
 */

namespace App\Classes\Report;


class GaReportGetPathPageViews extends GaReport
{


    public function getReport($path, $from = '2013-01-01', $to = 'today')
    {
        $this->init($path, $from, $to);
        return $this->get();
    }

    protected function setMetrics(): void
    {
        // Init the Metrics object.
        $this->metrics[0]->setExpression("ga:pageviews");
        $this->metrics[0]->setAlias("pageviews");

        $this->metrics[1]->setExpression("ga:uniquePageviews");
        $this->metrics[1]->setAlias("Unique Pageviews");
    }

    protected function setDimension(): void
    {
        // Init the Dimension object.
        $this->dimension->setName('ga:pagePath');
    }

    protected function setOrderBy(): void
    {
        //set OrderBy
        $this->orderBy->setOrderType("HISTOGRAM_BUCKET");
        $this->orderBy->setFieldName('ga:uniquePageviews');
    }

    /**
     * @param $path
     */
    protected function setDimensionFilter($path): void
    {
        $this->filter->setDimensionName('ga:pagePath');
        $this->filter->setOperator('EXACT');
        $this->filter->setExpressions([$path]);
    }
}