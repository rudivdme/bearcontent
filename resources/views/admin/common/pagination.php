<script id="pagination-template" type="text/x-handlebars-template">
    {{#with paginator}}
        <hr class="spacer" />
        {{#compare total '>' 0}}
            <p>Showing {{from}} to {{to}} of {{total}} entries.</p>
        {{/compare}}
        <input type="hidden" name="page" class="filter" value="{{current_page}}" data-auto-submit />
        {{#compare last_page '>' 1}}
            {{#pagination current_page last_page 10}}
                <ul class="ba-pagination">
                    {{#if isFirstPage}}
                        <li class="disabled"><span>&laquo;</span></li>
                    {{else}}
                        <li><a href="#" data-click-change="page" data-value="{{prevPage}}">&laquo;</a></li>
                    {{/if}}

                    {{#each pages}}
                        {{#if isCurrent}}
                            <li class="active"><span>{{page}}</span></li>
                        {{/if}}
                        {{#unless isCurrent}}
                            <li><a href="#" data-click-change="page" data-value="{{page}}">{{page}}</a></li>
                        {{/unless}}
                    {{/each}}

                    {{#if isLastPage}}
                        <li class="disabled"><span>&raquo;</span></li>
                    {{else}}
                        <li><a href="#" data-click-change="page" data-value="{{nextPage}}">&raquo;</a></li>
                    {{/if}}
                </div>
            {{/pagination}}
        {{/compare}}
    {{/with}}
</script>