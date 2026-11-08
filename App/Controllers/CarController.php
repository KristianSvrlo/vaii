<?php

namespace App\Controllers;

use App\Models\Car;
use Framework\Core\BaseController;
use Framework\Http\HttpException;
use Framework\Http\Request;
use Framework\Http\Responses\Response;

/**
 * Class CarController
 *
 * CRUD operácie nad entitou Car (garáž): zoznam, pridanie, úprava a odstránenie auta.
 *
 * @package App\Controllers
 */
class CarController extends BaseController
{
    /**
     * Všetky akcie sú dostupné bez prihlásenia (prihlasovanie sa v tejto úlohe nevyžaduje).
     */
    public function authorize(Request $request, string $action): bool
    {
        return true;
    }

    /**
     * READ – zobrazí zoznam všetkých áut z databázy.
     */
    public function index(Request $request): Response
    {
        return $this->html(['cars' => Car::getAll(orderBy: 'id')]);
    }

    /**
     * CREATE (1/2) – zobrazí prázdny formulár pre nové auto.
     */
    public function create(Request $request): Response
    {
        return $this->html(['car' => new Car(), 'input' => [], 'error' => null], 'form');
    }

    /**
     * UPDATE (1/2) – zobrazí formulár predvyplnený údajmi existujúceho auta.
     */
    public function edit(Request $request): Response
    {
        $car = $this->findCar($request->get('id'));
        return $this->html(['car' => $car, 'input' => $this->toInput($car), 'error' => null], 'form');
    }

    /**
     * CREATE (2/2) a UPDATE (2/2) – uloží údaje z formulára. Ak je v požiadavke `id`, auto sa upraví, inak sa vytvorí
     * nové. Po uložení presmeruje na zoznam, takže používateľ vidí aktuálny stav údajov.
     */
    public function save(Request $request): Response
    {
        if (!$request->isPost()) {
            return $this->redirect($this->url('index'));
        }

        $id = $request->post('id');
        $car = ($id !== null && $id !== '') ? $this->findCar($id) : new Car();

        // jednoduchá kontrola vstupu (typy stĺpcov year/power_kw sú čísla)
        $error = $this->validate($request);
        if ($error !== null) {
            return $this->html(['car' => $car, 'input' => $request->post(), 'error' => $error], 'form');
        }

        $car->setFromRequest($request);   // nastaví len vlastnosti z Car::$fillable
        if ($car->engine === '') {
            $car->engine = null;
        }
        if ($car->description === '') {
            $car->description = null;
        }
        $car->save();                     // INSERT alebo UPDATE podľa toho, či auto už v DB existuje

        return $this->redirect($this->url('index'))->setStatusCode(303);
    }

    /**
     * DELETE – odstráni auto z databázy (len cez POST) a presmeruje na zoznam.
     */
    public function delete(Request $request): Response
    {
        if ($request->isPost()) {
            $this->findCar($request->post('id'))->delete();
        }
        return $this->redirect($this->url('index'))->setStatusCode(303);
    }

    /**
     * Načíta auto podľa id, ak neexistuje, vyhodí chybu 404.
     */
    private function findCar(mixed $id): Car
    {
        $car = Car::getOne($id);
        if ($car === null) {
            throw new HttpException(404, 'Auto sa nenašlo.');
        }
        return $car;
    }

    /**
     * Základná kontrola formulára. Vráti text chyby alebo null, ak je všetko v poriadku.
     */
    private function validate(Request $request): ?string
    {
        if (trim((string)$request->post('brand')) === '' || trim((string)$request->post('model')) === '') {
            return 'Značka a model sú povinné.';
        }
        $year = filter_var($request->post('year'), FILTER_VALIDATE_INT);
        if ($year === false || $year < 1900 || $year > 2100) {
            return 'Rok výroby musí byť číslo od 1900 do 2100.';
        }
        $power = filter_var($request->post('powerKw'), FILTER_VALIDATE_INT);
        if ($power === false || $power < 1 || $power > 5000) {
            return 'Výkon musí byť celé číslo (kW) od 1 do 5000.';
        }
        return null;
    }

    /**
     * Hodnoty auta v tvare, v akom ich očakáva formulár.
     */
    private function toInput(Car $car): array
    {
        return [
            'brand' => $car->brand,
            'model' => $car->model,
            'year' => $car->year,
            'engine' => $car->engine,
            'powerKw' => $car->powerKw,
            'description' => $car->description,
        ];
    }
}
