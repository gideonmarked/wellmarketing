<?php namespace Grinkomeda\Networker\Components;

use Cms\Classes\ComponentBase;
use Grinkomeda\Networker\Models\Package;
use Grinkomeda\Networker\Models\Ticket;
use October\Rain\Exception\ApplicationException;

class TicketFactory extends ComponentBase
{

    public function componentDetails()
    {
        return [
            'name'        => 'TicketFactory Component',
            'description' => 'No description provided yet...'
        ];
    }

    public function onRun()
    {
        $this->getPackages();
        $this->getTickets();
    }

    public function defineProperties()
    {
        return [];
    }

    public function onCreate()
    {
        if(!ctype_digit( post('ticket_number') )) {
            throw new ApplicationException('You need to input a valid number!');
        } else if( post('specify_amount') != null
            && (post('specify_amount') < 1 || post('specify_amount') == '')) {
            throw new ApplicationException('You need to input a correct amount!');
        } else {
            $tickets = $this->createTickets( post('ticket_number') );
            foreach ($tickets as $key => $ticket) {
                $newticket = new Ticket;
                $newticket->code = $ticket;
                $newticket->amount = (
                                        post('specify_amount') != null
                                        && post('specify_amount') != 0 ?
                                        post('specify_amount') :
                                        post('package_amount'));
                $newticket->creation_date = date('Y-m-d H:i:s');
                $newticket->save();
            }

            $this->getTickets();
            
        }
    }

    public function onUpdatePackages()
    {
        if(post('package_amount') == 0)
            $this->page['specify'] = true;
    }

    public function getPackages()
    {
        $packages = Package::select('level_id','description','amount')->get();
        $specific_package = array(
                        'level_id' => 0,
                        'description' => 'Specify Amount',
                        'amount' => 0
            );
        $packages[] = $specific_package;
        $this->page['packages'] = $packages;
    }

    public function getTickets()
    {
        $this->page['tickets'] = Ticket::where('link_id',null)->get();
    }

    private function createTickets($count)
    {
        $tickets = [];
        for ($i=0; $i < $count; $i++) { 
            $tickets[] = $this->randomGeneration(7);
        }
        return $tickets;
    }

    private function randomGeneration($length)
    {
        $characters = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789';
        $string = '';
        for ($i = 0; $i < $length; $i++) {
            $string .= $characters[rand(0, strlen($characters) - 1)];
        }

        if( $this->checkUniqueTickets( $string ) ) {
            return $string;
        } else {
            return $this->randomGeneration($length);
        }
    }

    private function checkUniqueTickets( $string )
    {
        $ticketlist = Ticket::where('code',$string)->get();
        if(count($ticketlist) > 0) {
            return false;
        } else {
            return true;
        }
    }

}