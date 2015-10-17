<?php

namespace Bixie\Portfolio\Controller;

use Pagekit\Application as App;
use Bixie\Portfolio\Model\Project;

/**
 * @Access(admin=true)
 */
class PortfolioController
{
    /**
     * @Access("portfolio: manage portfolio")
     * @Request({"filter": "array", "page":"int"})
     */
    public function projectAction($filter = null, $page = 0)
    {
        return [
            '$view' => [
                'title' => __('Portfolio'),
                'name'  => 'bixie/portfolio/admin/portfolio.php'
            ],
            '$data' => [
				'statuses' => Project::getStatuses(),
				'config'   => [
                    'filter' => $filter,
                    'page'   => $page
                ]
            ]
        ];
    }

    /**
     * @Route("/project/edit", name="project/edit")
     * @Access("portfolio: manage portfolio")
     * @Request({"id": "int"})
     */
    public function editAction($id = 0)
    {
        try {

            if (!$project = Project::where(compact('id'))->first()) {

                if ($id) {
                    App::abort(404, __('Invalid project id.'));
                }

				$module = App::module('bixie/portfolio');

				$project = Project::create([
					'data' => [],
					'tags' => [],
					'status' => 1,
					'date' => new \DateTime()
				]);

				$project->set('markdown', $module->config('markdown'));

			}


            return [
                '$view' => [
                    'title' => $id ? __('Edit project') : __('Add project'),
                    'name'  => 'bixie/portfolio/admin/project.php'
                ],
                '$data' => [
					'statuses' => Project::getStatuses(),
					'config' => App::module('bixie/portfolio')->config(),
                	'project'  => $project,
                    'tags'     => Project::allTags()
                ],
                'project' => $project
            ];

        } catch (\Exception $e) {

            App::message()->error($e->getMessage());

            return App::redirect('@portfolio/post');
        }
    }

    /**
     * @Access("system: manage settings")
     */
    public function settingsAction()
    {
        return [
            '$view' => [
                'title' => __('Portfolio settings'),
                'name'  => 'bixie/portfolio/admin/settings.php'
            ],
            '$data' => [
                'config' => App::module('bixie/portfolio')->config()
            ]
        ];
    }
}
