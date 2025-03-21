<?php

namespace App\Providers;

use App\Models\CongregacoesCongregacao;
use App\Models\InstituicoesInstituicao;
use App\Models\PessoaFuncaoministerial;
use App\Models\PessoasDependente;
use App\Models\PessoasPessoa;
use App\Models\PessoasPrebenda;
use App\Models\Prebenda;
use App\Observers\ClerigosObserver;
use App\Observers\CongregacoesCongregacaoObserver;
use App\Observers\InstituicoesObserver;
use App\Observers\PessoaFuncaoministerialObserver;
use App\Observers\PessoaPrebendasObserver;
use App\Observers\PessoasDependenteObserver;
use App\Observers\PrebendaObserver;
use Illuminate\Auth\Events\Registered;
use Illuminate\Auth\Listeners\SendEmailVerificationNotification;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Event;

class EventServiceProvider extends ServiceProvider
{
    /**
     * The event to listener mappings for the application.
     *
     * @var array<class-string, array<int, class-string>>
     */
    protected $listen = [
        Registered::class => [
            SendEmailVerificationNotification::class,
        ],
    ];

    protected $observers = [
        CongregacoesCongregacao::class => [CongregacoesCongregacaoObserver::class],
        PessoasDependente::class => [PessoasDependenteObserver::class],
        PessoaFuncaoministerial::class => [PessoaFuncaoministerialObserver::class],
        PessoasPrebenda::class => [PessoaPrebendasObserver::class],
        InstituicoesInstituicao::class => [InstituicoesObserver::class],
        PessoasPessoa::class => [ClerigosObserver::class],
        Prebenda::class => [PrebendaObserver::class],
    ];

    /**
     * Register any events for your application.
     *
     * @return void
     */
    public function boot()
    {

    }

    /**
     * Determine if events and listeners should be automatically discovered.
     *
     * @return bool
     */
    public function shouldDiscoverEvents()
    {
        return false;
    }
}
