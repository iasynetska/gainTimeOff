<?php
namespace controllers;

class ReportReceivedMarksBlockController extends BlockParentController
{
    private function getKid($kidName)
    {
        $parent = $this->request->getSessionParam('parent');
        return $kidName!==null ? $parent->getKids()[$kidName] : $parent->getKids()[0];
    }

    public function getDashboardReportReceivedMarksBlockAction()
    {
        $this->checkRequestMethod($this->request::METHOD_GET);
        $kidName = $this->request->getGetParam('kidName');
        $startDate = $this->request->getGetParam('startDate');
        $endDate = $this->request->getGetParam('endDate');

        $this->content = $this->buildDashboardReportReceivedMarksBlock($this->getKid($kidName), $startDate, $endDate);
    }
}
