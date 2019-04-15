<?php

namespace App\Controller;
use App\Classes\Utilidades;
use App\Entity\Juego;
use App\Entity\Usuario;
use FOS\RestBundle\Controller\AbstractFOSRestController;
use FOS\RestBundle\Controller\Annotations as Rest;
use FOS\RestBundle\Controller\FOSRestController;
use Symfony\Component\HttpFoundation\Request;

/**
 * Class ApiJuegoController
 * @package App\Controller}
 */
class ApiJuegoController extends FOSRestController {

    /**
     * @return array
     * @Rest\Post("/v1/juego/nuevo")
     */
    public function nuevo(Request $request) {
        try {
            $em = $this->getDoctrine()->getManager();
            $raw = json_decode($request->getContent(), true);
            $respuesta = $em->getRepository(Juego::class)->nuevo($raw);
            if($respuesta['codigo_juego']) {
                $titulo = "Nuevo juego";
                $mensaje = $respuesta['jugador_seudonimo'] . " ha creado un juego";
                $this->get('notificacion')->notificarAmigos($raw['jugador'], $titulo, $mensaje, [
                    'type'      => 'new-game',
                    'path_data' => $respuesta['codigo_juego'],
                    'action'    => 'yes',
                ]);
            }
            return $respuesta;
        } catch (\Exception $e) {
            return [
                'error' => true,
                'mensaje' => $e->getMessage(),
            ];
        }
    }

    /**
     * @return array
     * @Rest\Post("/v1/juego/buscar")
     */
    public function buscar(Request $request) {
        try {
            $em = $this->getDoctrine()->getManager();
            return $em->getRepository(Juego::class)->buscar();
        } catch (\Exception $e) {
            return [
                'error' => true,
            ];
        }
    }

    /**
     * @return array
     * @Rest\Post("/v1/juego/detalle")
     */
    public function detalle(Request $request) {
        try {
            $raw = json_decode($request->getContent(), true);
            $em = $this->getDoctrine()->getManager();
            return $em->getRepository(Juego::class)->detalle($raw);
        } catch (\Exception $e) {
            return [
                'error' => true,
            ];
        }
    }

    /**
     * @return array
     * @Rest\Post("/v1/juego/jugador")
     */
    public function jugador(Request $request) {
        try {
            $raw = json_decode($request->getContent(), true);
            $em = $this->getDoctrine()->getManager();
            return $em->getRepository(Juego::class)->jugador($raw);
        } catch (\Exception $e) {
            return [
                'message' => $e->getMessage(),
                'error' => true,
            ];
        }
    }

    /**
     * @return array
     * @Rest\Post("/v1/juego/unir")
     */
    public function unir(Request $request) {
        try {
            $raw = json_decode($request->getContent(), true);
            $em = $this->getDoctrine()->getManager();
            $respuesta = $em->getRepository(Juego::class)->unir($raw);
            if($respuesta['codigo_juego']) {
                $titulo = "Nuevo juego";
                $mensaje = $respuesta['jugador_seudonimo'] . " se ha unido a tu juego";
                $this->get('notificacion')->notificarAmigos($raw['jugador'], $titulo, $mensaje, [
                    'type'      => 'new-game',
                    'path_data' => $respuesta['codigo_juego'],
                    'action'    => 'yes',
                ]);
            }
            return $respuesta;
        } catch (\Exception $e) {
            return [
                'error' => true,
            ];
        }
    }

    /**
     * @return array
     * @Rest\Post("/v1/juego/retirar")
     */
    public function retirar(Request $request) {
        try {
            $raw = json_decode($request->getContent(), true);
            $em = $this->getDoctrine()->getManager();
            return $em->getRepository(Juego::class)->retirar($raw);
        } catch (\Exception $e) {
            return [
                'error' => true,
            ];
        }
    }

    /**
     * @return array
     * @Rest\Post("/v1/juego/invitar")
     */
    public function invitar(Request $request) {
        try {
            $raw = json_decode($request->getContent(), true);
            $em = $this->getDoctrine()->getManager();
            return $em->getRepository(Juego::class)->invitar($raw);
        } catch (\Exception $e) {
            return [
                'error' => true,
            ];
        }
    }

    /**
     * @return array
     * @Rest\Post("/v1/juego/cerrar")
     */
    public function cerrar(Request $request) {
        try {
            $em = $this->getDoctrine()->getManager();
            $raw = json_decode($request->getContent(), true);
            return $em->getRepository(Juego::class)->cerrar($raw);
        } catch (\Exception $e) {
            return [
                'message' => $e->getMessage(),
                'error' => true,
            ];
        }
    }

}