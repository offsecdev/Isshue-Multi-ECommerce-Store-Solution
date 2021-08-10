$(document).ready(function () {
    "use strict";
    $("#wizard").aiiaWizard();
});

;
(function ($, window, document, undefined) {
    "use strict";

    var settings;

    ////////////////////////////////////////// Public methods

    var pub = {

        init: function (options) {

            return this.each(function () {

                var $this = $(this),
                        data = $this.data('aiiaWizard'),
                        aiiaWizard = $('<div />', {
                            text: $this.attr('title')
                        });

                //#region If the plugin hasn't been initialized yet
                if (!data) {

                    $(this).data('aiiaWizard', {});

                    $this.hide();

                    ///////////////////////// Main configurable options object

                    settings = $.extend(true, $.fn.aiiaWizard.defaults, options);
                    var globalMinHeight = settings.aiiaWizard.minHeight;
                    var buttonFinishText = settings.aiiaWizard.localization.buttons.finish;
                    var buttonLoadingText = settings.aiiaWizard.localization.buttons.loading;
                    var activeStep = settings.aiiaWizard.activeStep;

                    $(this).data('aiiaWizard').settings = settings;

                    ///////////////////////// Prepare Wizard components

                    var $stepsWrapper = getStepsWrapperTemplate(globalMinHeight);
                    var $buttons = getButtonsTemplate(settings);
                    var $steps = $this.find(".aiia-wizard-step");

                    var $buttonNext = $buttons.find(".aiia-wizard-button-next");
                    var $buttonPrevious = $buttons.find(".aiia-wizard-button-previous");

                    ///////////////////////// Place Wizard component

                    $stepsWrapper.append($steps);       // Place steps in the steps wrapper
                    $this.append($stepsWrapper);        // Place the steps wrapper that now contains all the steps in the original container
                    $this.append($buttons);             // Place Buttons right after the steps wrapper  

                    ///////////////////////// Shape Step elements

                    $steps.css({
                        'position': 'absolute',
                        'min-height': globalMinHeight + 'px',
                        'width': '100%'
                    });

                    ////////////////////////// Mark each step element with its current position to
                    ////////////////////////// easily keep track of the order (starting with 1)

                    $.each($steps, function (i, step) {
                        $(step).attr('data-position', i + 1);
                    })

                    var $progressButtonsTemplate = getProgressButtonsTemplate($steps, settings);
                    $this.prepend($progressButtonsTemplate);

                    /////////////////////////// Find the active step or set the first step active as default 

                    if (!$(".active").length) {
                        $steps.eq(activeStep - 1).addClass("active");
                        highlightActiveElement($this);
                    }

                    var $activeStep = $stepsWrapper.find(".active");
                    var activeElementPosition = parseInt($activeStep.data('position'), 10);

                    $.each($steps, function (i, step) {

                        var $step = $(step);
                        var $newStepTitleTemplate = getStepTitleTemplate(i, $step, settings);
                        $step.prepend($newStepTitleTemplate);

                        if ((i + 1) < activeElementPosition) {
                            moveStepLeft($step);
                            markStepAsCompleted(i + 1, $this, settings);
                        } else if ((i + 1) > activeElementPosition) {
                            moveStepRight($step);
                        } else {
                            showStep($step); // Only one element should satisfy this condition   
                            highlightActiveElement($this);
                            markStepAsCompleted(i + 1, $this, settings);
                        }

                    });

                    var $progressButtonsBorderBottom = getProgressButtonsBorderBottomTemplate(settings);
                    $progressButtonsTemplate.after($progressButtonsBorderBottom);

                    /////////////////////////// We can now show the plugin component
                    $this.show();

                    /////////////////////////// Activate buttons accordingly to which step is active

                    // If final step is shown
                    if (activeElementPosition === $steps.length) {
                        setFinishButton($this);
                    }

                    // If first step is shown
                    if (activeElementPosition === 1) {
                        $this.find('.aiia-wizard-button-previous').hide();
                    }

                    /////////////////////////// Register event handlers

                    $this.find('.aiia-wizard-button-previous').on('click',function (e) {
                        e.preventDefault();
                        var $elementToSlide = $this.find(".aiia-wizard-steps-wrapper .active");
                        $this.trigger("onButtonPreviousClick.aiiaWizard", this);

                        if ($.isFunction(settings.onButtonPreviousClick)) {
                            // Trigger the override callback it the callback is set at the plugin initialization...
                            settings.onButtonPreviousClick.call(this);
                        } else {
                            // ...slide right imediatelly otherwise.
                            slideRight($elementToSlide, settings, $this);
                        }
                    });

                    $this.on("slideRightSuccess.aiiaWizard", function () {
                        resizeWizardStepsWrapper($this);
                    });

                    $this.on("slideLeftSuccess.aiiaWizard", function () {
                        resizeWizardStepsWrapper($this);
                    });

                    $this.find('.aiia-wizard-button-next').on('click', function (e) {
                        e.preventDefault();
                        var $elementToSlide = $this.find(".aiia-wizard-steps-wrapper .active");

                        if ($.isFunction(settings.onButtonNextClick)) {
                            // Trigger the override callback it the callback is set at the plugin initialization...
                            settings.onButtonNextClick.call(this);
                        } else {
                            // ...slide left imediatelly otherwise.
                            slideLeft($elementToSlide, settings, $this);
                        }

                    });

                    /////////////////////////// Testing Success Icon

                    var $progressButtonsPlaceholder = $progressButtonsTemplate.find(".aiia-wizard-progress-buttons-placeholder");
                    var $progressButtons = $progressButtonsPlaceholder.children();

                    /////////////////////////// Store plugin data

                    $this.data('aiiaWizard').target = $this;
                    $this.data('aiiaWizard').aiiaWizard = aiiaWizard;
                    $this.data('aiiaWizard').settings = settings;

                    resizeWizardStepsWrapper($this);

                    $.isFunction(settings.onInitSuccess) && settings.onInitSuccess.call(this);
                    $this.trigger("initSuccess.aiiaWizard", this);
                }
                //#endregion
            });
        },
        isFinalElementShown: function (a, b) {
            var activeElementPosition = getActiveElementPosition($(this));
            if (activeElementPosition === countElements($(this))) {
                return true;
            } else {
                return false;
            }
        },
        hideButtonNext: function () {
            // TODO: implement
        },
        hideButtonPrevious: function () {
            // TODO: implement
        },
        previous: function () {
            previous($plugin);
        },
        next: function () {
            $plugin = $(this);
            var settings = $plugin.data('aiiaWizard').settings;
            var $elementToSlide = $plugin.find(".aiia-wizard-steps-wrapper .active");
            slideLeft($elementToSlide, settings, $plugin);
        },
        first: function (a) {
            previous(a, true);
            $plugin.on("slideRightSuccess.aiiaWizard", function (event, goToFirst) {
                if (goToFirst == true)
                    previous(a, true);
            });

        },
        final: function () {
            // TODO: implement
        },
        // disables the "previous" button for the provided step
        disablePreviousButton: function (stepNumber) {
            // TODO: implement
        },

        // enables the "previous" button for the provided step
        enablePreviousButton: function (stepNumber) {
            // TODO: implement
        },
        getActiveStep: function () {
            $plugin = $(this);
            return parseInt($plugin.find(".aiia-wizard-steps-wrapper .active").attr("data-position"), 10);
        }
    };

    ////////////////////////////////////////// Private functions 

    function resizeWizardStepsWrapper($this) {
        var $wizardStepsWrapper = $this.find(".aiia-wizard-steps-wrapper");
        var $activeStep = $wizardStepsWrapper.find(".active");

        $wizardStepsWrapper.clearQueue().animate({
            "height": $activeStep.height() + "px"
        });
    }

    function slideLeft($elementToSlide, settings, $plugin, slideSuccessCallback) {

        if ($elementToSlide.next().length) {

            $elementToSlide.clearQueue().animate({
                'margin-left': '-100%'
            });

            var $next = $elementToSlide.next();

            $next.clearQueue().animate({
                'margin-left': 0
            }, function () {

                $(".aiia-wizard-step").removeClass("active");
                $next.addClass("active");

                var activeElementPosition = highlightActiveElement($plugin);
                var stepsCount = $plugin.find(".aiia-wizard-step").length;

                markStepAsCompleted(activeElementPosition, $plugin, settings);

                if (activeElementPosition === stepsCount) {
                    setFinishButton($plugin);
                    $.isFunction(settings.onSlideLeftLimitReached) && settings.onSlideLeftLimitReached.call($plugin);
                    $plugin.trigger("slideLeftLimitReached.aiiaWizard", this);
                } else {
                    $plugin.find('.aiia-wizard-button-previous').show();
                }

                var $progressButtons = $plugin.find(".aiia-wizard-progress-buttons-placeholder").children();

                $.isFunction(settings.onSlideLeftFinished) && settings.onSlideLeftFinished.call($plugin);
                $plugin.trigger("slideLeftSuccess.aiiaWizard", this);
            });

        }

    }

    function slideRight($elementToSlide, settings, $plugin, goToFirst) {

        if ($elementToSlide.prev().length) {

            // Move the target element to the right first (out of the visual field)...
            $elementToSlide.clearQueue().animate({
                'margin-left': '100%'
            });

            // ...find the previous step element and move it into the visual field, thus making it the new active element.
            var $prev = $elementToSlide.prev();

            $prev.clearQueue().animate({
                'margin-left': 0
            }, function () {

                $plugin.find(".aiia-wizard-step").removeClass("active");

                $prev.addClass("active");

                var activeElementPosition = highlightActiveElement($plugin);
                unmarkStepAsCompleted(activeElementPosition, $plugin);

                if (activeElementPosition === 1) {
                    $plugin.find('.aiia-wizard-button-previous').hide();

                    $.isFunction(settings.onSlideRightLimitReached) && settings.onSlideRightLimitReached.call($plugin);
                    $plugin.trigger("slideRightLimitReached.aiiaWizard", this);
                } else {
                    if ($plugin.find('.aiia-wizard-button-next').hasClass('btn-success')) {
                        unsetFinishButton($plugin, settings);
                    }
                }

                $.isFunction(settings.onSlideRightFinished) && settings.onSlideRightFinished.call($plugin);
                $plugin.trigger("slideRightSuccess.aiiaWizard", goToFirst);

            });

        }
    }

    function getButtonsTemplate(settings) {
        var $buttons = $().css({
            'display': 'block'
        });

        var $iconPrevious = $("<span class='glyphicon glyphicon-chevron-left pull-left'></span>");
        var $iconPreviousText = $("<span>" + settings.aiiaWizard.localization.buttons.previous + "</span>");
        $iconPrevious.css(settings.aiiaWizard.buttons.previous.icon.css);
        $iconPreviousText.css(settings.aiiaWizard.buttons.previous.text.css);

        var $iconNext = $("<span class='glyphicon glyphicon-chevron-right pull-right'></span>");
        var $iconNextText = $("<span>" + settings.aiiaWizard.localization.buttons.next + "</span>");
        $iconNext.css(settings.aiiaWizard.buttons.next.icon.css);
        $iconNextText.css(settings.aiiaWizard.buttons.next.text.css);

        $buttons.find(".btn").css(settings.aiiaWizard.buttons.css);

        $buttons.find(".aiia-wizard-button-previous")
                .append($iconPreviousText);

        $buttons.find(".aiia-wizard-button-next")
                .append($iconNextText);

        return $buttons;
    }

    function highlightActiveElement($plugin) {

        // find the active element position
        var $stepsWrapper = $plugin.find(".aiia-wizard-steps-wrapper");
        var $activeElement = $stepsWrapper.find(".active");
        var activeElementPosition = parseInt($activeElement.data('position'), 10);

        var $progressButtons = $plugin.find(".aiia-wizard-progress-buttons-placeholder");
        $progressButtons.find(".active").removeClass("active");
        $progressButtons.find("li[data-position='" + activeElementPosition + "']").addClass("active");

        return activeElementPosition;
    }

    function getStepsWrapperTemplate(globalMinHeight) {
        var result = $("<div class='aiia-wizard-steps-wrapper'></div>")
                .css({
                    'position': 'relative',
                    'overflow': 'hidden',
                    'width': '100%',
                    'min-height': globalMinHeight + 'px'
                });
        return result;
    }

    function getProgressButtonsTemplate($steps, settings) {

        var $progessButtonsWrapper = $("" +
                "<div class='aiia-wizard-progress-buttons-wrapper row'>" +
                "<div class='col-md-12'>" +
                "<ul class='nav nav-pills nav-justified aiia-wizard-progress-buttons-placeholder'>" +
                "</ul>" +
                "</div>" +
                "</div>" +
                "").css({
            'display': 'block'
        });

        $.each($steps, function (i, step) {
            var $step = $(step);
            var cls = "";
            var pos = parseInt($step.data('position'), 10);

            var $progressButton = $("" +
                    "<li data-position='" + $step.attr('data-position') + "'><a href='#'><h1>" + $step.data('position') + ". </h1>" + $step.find('h1').html() + "</a></li>" +
                    "");

            if ($step.hasClass("active") && settings.aiiaWizard.progressButtons.markActive) {
                $progressButton.removeClass('default');
                $progressButton.addClass('active');
            }

            $progressButton.css(settings.aiiaWizard.progressButtons.css);

            $progessButtonsWrapper.find(".aiia-wizard-progress-buttons-placeholder").append($progressButton);

        });

        return $progessButtonsWrapper
    }

    function getProgressButtonsBorderBottomTemplate(settings) {

        var $hr = $("<hr/>");

        $hr.css(settings.aiiaWizard.progressButtons.borderBottom.css);

        return $hr;

    }

    function getStepTitleTemplate(i, $step, settings) {

        var stepNumber = i + 1;
        var $stepTitle = $step.find("h1");
        var stepTitleText = $stepTitle.html();

        var $stepNumber = $("<h1 class='pull-left'>" + stepNumber + "</h1>");
        var $stepText = $("<span>" + stepTitleText + "</span>")
        $stepTitle.remove();

        var $newStepTitle = $("" +
                "<div class='row aiia-wizard-step-title'>" +
                "<div class='col-md-12'>" +
                "<span class='aiia-wizard-step-title-number'>" + stepNumber + "</span>" +
                "<span class='aiia-wizard-step-title-text'>" + stepTitleText + "</span>" +
                "</div>" +
                "</div>" +
                "" +
                "");

        $newStepTitle.find(".aiia-wizard-step-title-number").css(settings.aiiaWizard.steps.title.number.css);
        $newStepTitle.find(".aiia-wizard-step-title-text").css(settings.aiiaWizard.steps.title.text.css);

        return $newStepTitle;
    }

    function moveStepLeft($s) {
        $s.css({
            'margin-left': '-100%'  // move all lower steps to the left
        });
    }

    function moveStepRight($s) {
        $s.css({
            'margin-left': '100%'  // move all lower steps to the left
        });
    }

    function showStep($s) {
        $s.css({
            'margin-left': 0
        });
    }

    function getActiveElementPosition($pluginElement) {
        var stringResult = $pluginElement
                .find(".aiia-wizard-steps-wrapper")
                .find(".active").data('position');

        return parseInt(stringResult, 10);
    }

    function countElements($pluginElement) {
        return $pluginElement.find(".aiia-wizard-step").length;
    }

    function setFinishButton($pluginElement, text) {
        var $finishButton = $pluginElement.find(".aiia-wizard-button-next");

        var txt = $pluginElement.data('aiiaWizard').settings.aiiaWizard.localization.buttons.finish;
        if (text)
            txt = text;

        $finishButton.css(settings.aiiaWizard.buttons.finish.text.css);

        $finishButton
                .removeClass('btn-success')
                .addClass('btn-success')
                .html(txt);
    }

    function unsetFinishButton($pluginElement, settings) {
        var $finishButton = $pluginElement.find(".aiia-wizard-button-next");
        var txt = $pluginElement.data('aiiaWizard').settings.aiiaWizard.localization.buttons.next;
        var $iconNext = $("<span class='glyphicon glyphicon-chevron-right pull-right'></span>");
        var $iconNextText = $("<span>" + settings.aiiaWizard.localization.buttons.next + "</span>");
        $iconNext.css(settings.aiiaWizard.buttons.next.icon.css);

        $iconNextText.css(settings.aiiaWizard.buttons.next.text.css);

        $finishButton
                .removeClass('btn-success')
                .addClass('btn-success')
                .html("")
                .append($iconNextText)
    }

    function markStepAsCompleted(activeElementPosition, $plugin, settings) {

        $plugin.find("[data-position='" + (activeElementPosition - 1) + "']").addClass("completed");


        // find the target progressButton to mark as completed
        var $progressButton = $plugin.find(".aiia-wizard-progress-buttons-placeholder").find("[data-position='" + (activeElementPosition - 1) + "']");

        // create a new success icon to place it on the progress button
        var $successIcon = $("<span class='" + settings.aiiaWizard.progressButtons.completed.icon.cssClass + " aiia-wizard-icon-step-completed'></span>")
                .css(settings.aiiaWizard.progressButtons.completed.icon.css);

        var $a = $progressButton.find("a");
        // When the step is completed, the progress button must show it with a new style (gray by default)...
        $a.css(settings.aiiaWizard.progressButtons.completed.css);
        // ...and with a success icon appended.
        $a.append($successIcon);
    }

    function unmarkStepAsCompleted(activeElementPosition, $plugin) {

        var $progressButton = $plugin.find(".aiia-wizard-progress-buttons-placeholder").find("[data-position='" + activeElementPosition + "']");
        $progressButton.find(".aiia-wizard-icon-step-completed").remove();
        var $a = $progressButton.find("a");
        $a.removeAttr("style");
    }

    function previous($plugin, goToFirst) {
        var settings = $plugin.data('aiiaWizard').settings;
        var $elementToSlide = $plugin.find(".aiia-wizard-steps-wrapper .active");
        var activeStep = parseInt($plugin.find(".aiia-wizard-steps-wrapper .active").attr("data-position"), 10);
        if (activeStep > 0) {
            slideRight($elementToSlide, settings, $plugin, goToFirst);
        }
    }


    ////////////////////////////////////////// Plugin definition

    $.fn.aiiaWizard = function (method) {

        if (pub[method]) {
            return pub[method].apply(this, Array.prototype.slice.call(arguments, 1));
        } else if (typeof method === 'object' || !method) {
            return pub.init.apply(this, arguments);
        } else {
            $.error('Method ' + method + ' does not exist on jQuery.aiiaWizard');
        }

    };

    ////////////////////////////////////////// Plugin Options

    $.fn.aiiaWizard.defaults = {
        aiiaWizard: {
            minHeight: 400,
            activeStep: 1,
            localization: {
                buttons: {
                    next: 'Next',
                    previous: 'Previous',
                    finish: 'Finish',
                    loading: 'Loading...'
                }
            },
            progressButtons: {
                borderBottom: {
                    css: {
                        'border-width': '4px',
                        'border-color': '#E6E6E6'
                    }
                },
                css: {
                    'padding': '0 43px',

                },
                markActive: false,
                completed: {
                    css: {
                        'background-color': '#E6E6E6'
                    },
                    icon: {
                        cssClass: 'glyphicon glyphicon-ok-sign',
                        css: {
                            'position': 'absolute',
                            'top': '-20px',
                            'right': '-17px',
                            'font-size': '4em',
                            'color': 'green'
                        }
                    }
                }

            },
            steps: {
                title: {
                    number: {
                        css: {
                            'background-color': '#37a000',
                            '-webkit-border-radius': '300px',
                            '-moz-border-radius': '300px',
                            'border-radius': '300px',
                            'color': '#FFFFFF',
                            'float': 'left',
                            'font-size': '25px',
                            'height': '42px',
                            'margin-right': '10px',
                            'text-align': 'center',
                            'width': '42px',
                            'font-weight': 'bold',
                            'line-height': '42px'
                        }
                    },
                    text: {
                        css: {
                            'color': '#333',
                            'font-size': '26px',
                            'float': 'left',
                            'margin-top': '4px',
                            'font-weight': '600'
                        }
                    }
                },
                content: {

                }
            },
            buttons: {
                previous: {
                    text: {
                        css: {
                        }
                    },
                    icon: {
                        css: {
                        }
                    }

                },
                next: {
                    text: {
                        css: {
                        }
                    },
                    icon: {
                        css: {
                        }
                    }
                },
                'css': {
                },
                finish: {
                    text: {
                        css: {
                        }
                    }
                },
                'css': {
                }

            }
        }
    };

})(jQuery, window, document);