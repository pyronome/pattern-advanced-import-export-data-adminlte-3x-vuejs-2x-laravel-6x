
    /**
     * Define the "adminlte" routes for the application.
     *
     * These routes are typically stateless.
     *
     * @return void
     */
    protected function mapAdminLTEAdvancedRoutes()
    {
        $adminLTEFolder = config('adminlte.main_folder');
        Route::prefix($adminLTEFolder . '/advanced')
                ->middleware([
                \App\Http\Middleware\EncryptCookies::class,
                \Illuminate\Cookie\Middleware\AddQueuedCookiesToResponse::class,
                \Illuminate\Session\Middleware\StartSession::class,
	            \Illuminate\View\Middleware\ShareErrorsFromSession::class,
    	        \Illuminate\Routing\Middleware\SubstituteBindings::class,
                AdminLTEMiddleware::class])
                ->namespace('App\Http\Controllers\AdminLTE')
                ->group(base_path('routes/adminlte-advanced.php'));
    }
        $this->mapAdminLTEAdvancedRoutes();