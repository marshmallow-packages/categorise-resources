<template>
    <div>
        <h3
            ref="nova-category nc"
            class="flex items-center font-normal text-white mb-6 text-base no-underline cursor-pointer nova-category-toggler nc-head"
            @click.prevent="toggle"
        >
            <span class="nc-icon" v-html="icon"></span>

            <span class="nc-label">{{ header }}</span>
            <template v-if="expanded">
                <span class="nc-toggle toggle-button">&minus;</span>
            </template>
            <template v-else>
                <span class="nc-toggle toggle-button">&plus;</span>
            </template>
        </h3>

        <transition-group
            tag="ul"
            class="list-reset nc-list"
            :class="{ 'mb-6': last }"
        >
            <slot @click.prevent="sidebarToggle" v-if="expanded"></slot>
        </transition-group>
    </div>
</template>

<script>
    export default {
        props: {
            header: String,
            icon: String,
            last: Boolean,
        },
        data() {
            return {
                expanded: false,
            };
        },
        methods: {
            toggle() {
                this.expanded = !this.expanded;
				this.sidebarLinks = document.querySelectorAll(
					".w-sidebar a, .w-sidebar .cursor-pointer:not(.nc-head), .w-sidebar .nc-item-link"
				);
            },

            getClosest(elem, selector) {
                // Element.matches() polyfill
                if (!Element.prototype.matches) {
                    Element.prototype.matches =
                        Element.prototype.matchesSelector ||
                        Element.prototype.mozMatchesSelector ||
                        Element.prototype.msMatchesSelector ||
                        Element.prototype.oMatchesSelector ||
                        Element.prototype.webkitMatchesSelector ||
                        function(s) {
                            var matches = (
                                    this.document || this.ownerDocument
                                ).querySelectorAll(s),
                                i = matches.length;
                            while (--i >= 0 && matches.item(i) !== this) {}
                            return i > -1;
                        };
                }

                // Get the closest matching element
                for (; elem && elem !== document; elem = elem.parentNode) {
                    if (elem.matches(selector)) return elem;
                }
                return null;
            }
        },

        created: function() {
            let self = this;


            /**
             * Close expanded versions other then the one that is clicked now.
             */
            window.addEventListener("click", function(e) {

				/**
				* Close side if Child element is clicked.
				*/
				document.querySelectorAll(".w-sidebar .nc-item-link").forEach(function(sidebarLink) {
					sidebarLink.addEventListener("click", function() {
						document.querySelector(".w-sidebar").classList.add("sidebar-hidden");
					}, false);
				});

                var parent = self.getClosest(
                    e.target,
                    ".nova-category-toggler"
                );

                if (parent && !self.$el.contains(e.target)) {
                    self.expanded = false;
                }
            });
        },
    };
</script>

<style type="text/css">
    .cursor {
        cursor: pointer;
    }
    .nova-category-toggler {
        position: relative;
    }
    .nova-category-toggler .toggle-button {
        position: absolute;
        right: 0;
        top: 2px;
    }
</style>
