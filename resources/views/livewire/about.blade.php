<div>
    @include('partials.about.header',      ['section' => $this->sections['header']])
    @include('partials.about.intro',       ['section' => $this->sections['intro']])
    @include('partials.about.team',        ['section' => $this->sections['team'], 'teamMembers' => $teamMembers])
    @include('partials.about.testimonials',['section' => $this->sections['testimonials'], 'testimonials' => $testimonials])
    @include('partials.about.partners',    ['section' => $this->sections['partners']])
</div>
