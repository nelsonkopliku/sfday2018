<?php

declare(strict_types=1);

namespace App\Controller;

use App\Dto\LocalesList;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class LocaleController extends AbstractController
{
    /**
     * @Route(
     *     path="/api/locales",
     *     name="api_get_locales",
     *     methods={"GET"},
     *     defaults={
     *          "_api_respond"=true,
     *          "_api_normalization_context"={"api_sub_level"=true},
     *          "_api_swagger_context"={
     *              "tags"={"Locales"},
     *              "summary"="Retrieve locales availables",
     *              "parameters"={},
     *              "responses"={
     *                  "200"={
     *                      "description"="List of available locales and the default locale",
     *                      "schema"={
     *                          "type"="object",
     *                          "properties"={
     *                              "defaultLocale"={"type"="string"},
     *                              "locales"={"type"="array", "items"={"type"="string"}}
     *                          }
     *                      }
     *                  }
     *              }
     *          }
     *     }
     * )
     */
    public function __invoke(): LocalesList
    {
        $response = new LocalesList();
        $response->locales = explode('|', $this->getParameter('locales'));
        $response->defaultLocale = $this->getParameter('locale');

        return $response;
    }
}
