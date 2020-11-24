<?php
/**
 * Created by PhpStorm.
 * User: prakashpokhrel
 * Date: 26/10/2017
 * Time: 9.22
 */

namespace App\Zen\Setting\Model;


use App\Repository\Eloquent\Repository;
use App\Zen\Lease\Model\LeaseType;
use App\Zen\Setting\Features\Import\Upload\PortfolioUpload;
use Illuminate\Support\Facades\Auth;

class PortfolioRepository extends Repository
{
    public function model()
    {
        return Portfolio::class;
    }

    public function getIndexViewData()
    {
    }

    public function getEditViewData($id)
    {
        return $this->find($id);
    }

    public function getCreateViewData()
    {
    }

    public function handleCreate($request)
    {
        $this->create($request->all() + ['user_id' => Auth::id()]);
    }

    public function handleEdit($request, $id)
    {
        $this->find($id)->update($request->all() + ['updated_user_id' => Auth::id()]);
    }

    public function handleImport()
    {
        $file = request() -> file('portfolio_excel');

        list($extension, $numberOfUploads) = (new PortfolioUpload()) -> uploadToDatabase($file);

        flash() -> overlay($numberOfUploads . ' portfolio(s) are imported from ' . $extension . ' file') -> message();
    }

    public function checkDeletable(int $id)
    {
        $portfolio = Portfolio ::with( 'leases') -> findOrFail($id);
        return count($portfolio -> leases);
    }

}