<div>
    @include('partials.home.hero', ['section' => $this->sections['hero']])
    @include('partials.home.mission', ['section' => $this->sections['mission']])
    @include('partials.home.expertise', ['section' => $this->sections['expertise']])
    @include('partials.home.services-banner', ['section' => $this->sections['services_banner']])
    @include('partials.home.investment', ['section' => $this->sections['investment']])
    @include('partials.home.contact', ['section' => $this->sections['contact']])
    @include('partials.home.agents', ['section' => $this->sections['agents'], 'agents' => $agents])
    @include('partials.home.testimonials', ['section' => $this->sections['testimonials'], 'testimonials' => $testimonials])
    @include('partials.home.partners', ['section' => $this->sections['partners']])
</div>
