<template>
    <div>
        <div class="words">
            <div class="words__header">Most frequent words</div>
            <div class="words__content">
                <p v-for="(item, index) in words">
                    {{index}} <span>({{item}})</span>
                </p>
            </div>
        </div>
        <div class="table" role="table" aria-label="Destinations">
            <div class="table__header" role="rowgroup">
                <div class="table__item" role="columnheader">title</div>
                <div class="table__item" role="columnheader">Summary</div>
            </div>
            <div class="table__row" role="rowgroup" v-for="(item) in articles">
                <div class="table__item" role="cell">
                    <a :href="item.author_link" class="table__row__author">{{item.author_name}}</a>
                    <a :href="item.link" class="table__row__title">{{item.title}}</a>
                </div>
                <div class="table__item" role=" cell">
                    <div v-html="item.description"></div>
                    <div class="table__item__date">{{item.date | moment("D MMMM YYYY")}}</div>
                </div>

            </div>
        </div>
        <div class="pagination">
            <div v-for="(item) in pagination">
                <router-link v-if="item.type === 'link'" class="pagination__link" :class="item.class"
                             :to="{path: '/article/' + item.page}">
                    {{item.page}}
                </router-link>
                <div v-else class="pagination__separator">...</div>
            </div>

        </div>
    </div>
</template>

<script>
    import axios from 'axios';
    import moment from 'vue-moment';
    export default {
        name: "article_list",
        data() {
            return {
                words: [],
                articles: [],
                pageNumber: 1, //total pages
                page: 1, // current page
                pagination: []
            }
        },
        mounted: function () {
            this.loadArticles();
        },
        watch: {
            //update if url changed (for pagination)
            '$route'(to, from) {
                this.loadArticles()
            }
        },
        methods: {
            loadArticles: function () {
                let $this = this;

                $this.$root.showLoading();

                //add page index from route variables
                $this.page = this.$route.params.page ? parseInt(this.$route.params.page) : 1;

                //Loading articles
                axios({
                    url: '/api/article/get-list',
                    method: 'get',
                    params: {
                        'page': $this.page
                    }
                })
                    .then(function (response) {
                        $this.pageNumber = response.data.page_count;
                        $this.articles = response.data.articles;
                        $this.words = response.data.words;
                        if ($this.pageNumber < $this.page) {
                            $this.page = $this.pageNumber
                        }
                        $this.pagination = $this.calcPagination();
                        $this.$root.removeLoading();
                    });
            },
            // well, i tried to make my own pagination, at least it was interesting experience :D
            calcPagination: function () {
                let pagination = [];
                if (this.pageNumber < 6) {
                    pagination = this.addLink(pagination, [1, 2, 3, 4, 5])
                } else {
                    pagination = this.addLink(pagination, [1]);

                    if (this.page > 3) {
                        pagination = this.addSeparator(pagination);
                        pagination = this.addLink(pagination, [this.page - 1, this.page]);
                        if (this.pageNumber === this.page) {
                            return pagination;
                        }

                        if (this.page <= this.pageNumber - 2) {
                            pagination = this.addLink(pagination, [this.page + 1]);

                        }
                    } else {
                        pagination = this.addLink(pagination, [2, 3]);

                        if (this.page === 3) {
                            pagination = this.addLink(pagination, [4]);
                        }
                    }

                    if (this.page < this.pageNumber - 2) {
                        pagination = this.addSeparator(pagination);

                    }
                    pagination = this.addLink(pagination, [this.pageNumber]);
                }
                return pagination;
            },
            // link template for calcPagination function
            addLink: function (pagination, pageNumbers) {
                let $this = this;
                pageNumbers.forEach(function (item) {
                    pagination.push({
                        'page': item,
                        'type': 'link',
                        'class': $this.page === item ? 'active' : ''
                    })
                });
                return pagination;
            },
            // Separator template for calcPagination function
            addSeparator: function (pagination) {
                pagination.push({
                    'type': 'separator',
                });
                return pagination;
            }
        }
    }
</script>

<style scoped>

</style>