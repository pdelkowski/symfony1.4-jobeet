<?php

class JobeetJobApi extends JobeetJob
{
	/**
	 * Return an array of active jobs
	 * @param  Doctrine_Collection $c
	 * @return array()
	 */
	public static function generateJobArrayApi(Doctrine_Collection $c)
	{
		$jobs = array();
		$context = sfContext::getInstance();
		$routing = $context->getRouting();

		foreach ($c as $job)
	    {
	      $jobs[$routing->generate('job_show_user', $job, true)] = $job->asArray('learnsymfony.dev');
	    }

	    return $jobs;
	}
}