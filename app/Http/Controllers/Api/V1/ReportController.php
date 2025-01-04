<?php

namespace App\Http\Controllers\Api\V1;

use App\Actions\V1\Report\GenerateReportTicketsAction;
use App\Actions\V1\Report\SearchTicketsByEmployeeAndPeriodAction;
use App\Http\Controllers\Controller;
use App\Http\Requests\Api\V1\Report\SearchTicketsRequest;
use App\Http\Resources\V1\SearchTicketsResource;
use App\Traits\HttpResponse;
use Illuminate\Http\JsonResponse;
use OpenApi\Annotations as OA;

/**
 * @OA\Schema(
 *     schema="TicketReport",
 *     type="object",
 *     title="Ticket Report",
 *     description="Ticket Report Response",
 *     @OA\Property(
 *         property="employee_id",
 *         type="integer",
 *         description="ID do funcionário",
 *         example=1
 *     ),
 *     @OA\Property(
 *         property="start_date",
 *         type="string",
 *         format="date",
 *         description="Data inicial",
 *         example="2024-01-01"
 *     ),
 *     @OA\Property(
 *         property="end_date",
 *         type="string",
 *         format="date",
 *         description="Data final",
 *         example="2024-12-31"
 *     )
 * )
 */

/**
 * Class ReportController
 * @package App\Http\Controllers\Api\V1
 * Classe responsável por gerar relatórios
 */
class ReportController extends Controller
{
    use HttpResponse;

    /**
     * @OA\Get(
     *     path="/api/v1/reports/tickets/by/employee/period",
     *     tags={"Relatórios"},
     *     summary="Busca tickets por funcionário e período",
     *     @OA\Parameter(
     *         name="employee_id",
     *         in="query",
     *         description="ID do funcionário",
     *         required=false,
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Parameter(
     *         name="start_date",
     *         in="query",
     *         description="Data inicial",
     *         required=true,
     *         @OA\Schema(type="string", format="date")
     *     ),
     *     @OA\Parameter(
     *         name="end_date",
     *         in="query",
     *         description="Data final",
     *         required=true,
     *         @OA\Schema(type="string", format="date")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Lista de tickets encontrados",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(property="message", type="string", example="Tickets"),
     *             @OA\Property(
     *                 property="data",
     *                 type="array",
     *                 @OA\Items(ref="#/components/schemas/Ticket")
     *             )
     *         )
     *     ),
     *     @OA\Response(
     *         response=400,
     *         description="Erro de validação",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(
     *                 property="message",
     *                 type="object",
     *                 @OA\Property(property="start_date", type="array", @OA\Items(type="string", example="The start date field is required"))
     *             )
     *         )
     *     )
     * )
     */
    /**
     * @param SearchTicketsByEmployeeAndPeriodAction $action
     * @param SearchTicketsRequest $request
     * @return JsonResponse
     * Método responsável por buscar tickets por funcionário e período
     */
    public function searchTicketsByEmployeeAndPeriod(
        SearchTicketsByEmployeeAndPeriodAction $action,
        SearchTicketsRequest                   $request
    ): JsonResponse
    {
        $tickets = $action->execute($request);
        return $this->response(
            "Pesquisa de Tickets",
            "200",
            SearchTicketsResource::collection($tickets),
        );

    }

    /**
     * @OA\Post(
     *     path="/api/v1/reports/tickets/generate",
     *     tags={"Relatórios"},
     *     summary="Gera relatório PDF de tickets",
     *     description="Gera um relatório PDF dos tickets baseado nos filtros fornecidos",
     *     @OA\Parameter(
     *         name="employee_id",
     *         in="query",
     *         description="ID do funcionário",
     *         required=false,
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Parameter(
     *         name="start_date",
     *         in="query",
     *         description="Data inicial",
     *         required=false,
     *         @OA\Schema(type="string", format="date")
     *     ),
     *     @OA\Parameter(
     *         name="end_date",
     *         in="query",
     *         description="Data final",
     *         required=false,
     *         @OA\Schema(type="string", format="date")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Relatório PDF gerado com sucesso",
     *         @OA\Header(
     *             header="Content-Type",
     *             description="application/pdf",
     *             @OA\Schema(type="string")
     *         ),
     *         @OA\Header(
     *             header="Content-Disposition",
     *             description="attachment; filename=tickets.pdf",
     *             @OA\Schema(type="string")
     *         )
     *     ),
     *     @OA\Response(
     *         response=400,
     *         description="Erro de validação",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(
     *                 property="message",
     *                 type="object",
     *                 @OA\Property(property="employee_id", type="array", @OA\Items(type="string", example="The selected employee id is invalid"))
     *             )
     *         )
     *     )
     * )
     */
    /**
     * @param SearchTicketsRequest $request
     * @param GenerateReportTicketsAction $action
     * @return \Illuminate\Http\Response|JsonResponse
     * Método responsável por gerar o relatório de tickets
     */
    public function generateReportSearchTickets(
        SearchTicketsRequest        $request,
        GenerateReportTicketsAction $action
    ): \Illuminate\Http\Response|JsonResponse
    {
        try {
            $pdf = $action->execute($request);
            return response($pdf->stream())
                ->header('Content-Type', 'application/pdf')
                ->header('Content-Disposition', 'attachment; filename=tickets.pdf');

        } catch (\Exception $e) {
            return $this->error("Erro ao gerar relatório", "400", ['message' => $e->getMessage()]);
        }
    }
}
