!function (o) {
    "use strict";
    function e() {
        this.$body = o("body"),
            this.$modal = o("#event-modal"),
            this.$event = "#external-events div.external-event",
            this.$calendar = o("#calendar"),
            this.$saveCategoryBtn = o(".save-category"),
            this.$categoryForm = o("#add-category form"),
            this.$extEvents = o("#external-events"),
            this.$calendarObj = null
    }
    e.prototype.onDrop = function (e, t) {
        var n = e.data("eventObject"),
            a = e.attr("data-class"),
            l = o.extend({}, n);
        l.start = t, a && (l.className = [a]),
            this.$calendar.fullCalendar("renderEvent", l, !0),
            o("#drop-remove").is(":checked") && e.remove()
    },
        e.prototype.onEventClick = function (t, e, n) {
            var a = this, l = o("<form></form>");
            l.append("<label>Change event name</label>"),
                l.append("<div class='input-group m-b-15'><input class='form-control' type=text value='" + t.title + "' /><span class='input-group-append'><button type='submit' class='btn btn-success btn-md  '><i class='fa fa-check'></i> Save</button></span></div>"),
                a.$modal.modal({ backdrop: "static" }),
                a.$modal.find(".delete-event").show().end()
                    .find(".save-event").hide().end().
                    find(".modal-body").empty().prepend(l).end()
                    .find(".delete-event").unbind("click")
                    .click(function () {
                        a.$calendarObj.fullCalendar("removeEvents", function (e) {
                            return e._id == t._id
                        }),
                            a.$modal.modal("hide")
                    }),
                a.$modal.find("form")
                    .on("submit", function () {
                        return t.title = l.find("input[type=text]").val(),
                            a.$calendarObj.fullCalendar("updateEvent", t),
                            a.$modal.modal("hide"), !1
                    })
        },
        e.prototype.onSelect = function (n, a, e) {
            var l = this;
            l.$modal.modal({ backdrop: "static" });
            var i = o("<form></form>");
            if (n >= o.now()) {
                i.append("<div class='row'></div>"),
                    i.find(".row")
                        .append("<div class='col-12'><div class='form-group'><label class='control-label'>Description</label><input class='form-control' placeholder='Insert une description' type='text' name='description'/></div></div>")
                        .append("<div class='col-6'><div class='form-group'><label class='control-label'>Début</label><input class='form-control' placeholder='heure de début' type='time' name='begin_at'/></div></div>")
                        .append("<div class='col-6'><div class='form-group'><label class='control-label'>Fin</label><input class='form-control' placeholder='heure de fin' type='time' name='end_at'/></div></div>"),
                    l.$modal.find(".delete-event").hide().end()
                        .find(".save-event").show().end()
                        .find(".modal-body").empty().prepend(i).end()
                        .find(".save-event").unbind("click")
                        .click(function () {
                            i.submit()
                        }),
                    l.$modal.find("form")
                        .on("submit", function () {
                            var e = i.find("input[name='description']").val(),
                                b = i.find("input[name='begin_at']").val(),
                                f = i.find("input[name='end_at']").val(),
                                user_id = document.getElementById('user_id').value,
                                room_id = document.getElementById('room_id').value,
                                token = $("input[name='_token']").val();
                            axios.defaults.headers['x-csrf-token'] = token;
                            axios.post(`/reservations`,
                                { date: n.format('YYYY-MM-DD').toString(), begin_at: b + ':00', end_at: f + ':00', description: e, user_id: user_id, room_id: room_id },
                                { withCredentials: true, xsrfCookieName: "XSRF-TOKEN", xsrfHeaderName: "X-XSRF-TOKEN" })
                                .then(res => {
                                    console.log(res.data);
                                })
                                .catch(err => {
                                    console.log(err.message);
                                })
                            let start = new Date(n.format('YYYY-MM-DD').toString() + ' ' + b + ':00'),
                                end = new Date(n.format('YYYY-MM-DD').toString() + ' ' + f + ':00');
                            console.log(user_id, room_id, token);
                            return null !== e && 0 != e.length ? (
                                l.$calendarObj.fullCalendar("renderEvent",
                                    { title: e, start: start, end: end, allDay: !1, className: start === o.now() ? "bg-danger" : start > o.now() ? "bg-warning" : "bg-success" }, !0),
                                l.$modal.modal("hide")) : alert("You have to give a title to your event"), !1
                        }), l.$calendarObj.fullCalendar("unselect")
            } else {
                i.append("<div class='row'></div>"),
                    i.find(".row")
                        .append("<div class='col-12'><div class='form-group'><h2>Alert!<h2/><p>Cette date est inférieur à aujourd'hui</p></div></div>"),
                    l.$modal.find(".delete-event").hide().end()
                        .find(".modal-body").empty().prepend(i).end()
                        .find(".save-event").hide().end()
            }
        },
        e.prototype.enableDrag = function () {
            o(this.$event).each(function () {
                var e = { title: o.trim(o(this).text()) };
                o(this).data("eventObject", e),
                    o(this).draggable({
                        zIndex: 999, revert: !0, revertDuration: 0
                    });
            })
        }, e.prototype.init = async function () {
            this.enableDrag();
            let room_id = document.getElementById('room_id').value,
                data = JSON.parse(document.getElementById('room_datas').value);
            var e = new Date,
                t = (e.getDate(),
                    e.getMonth(),
                    e.getFullYear(),
                    new Date(o.now())),
                /* n = await datas, */
                a = this;
            a.$calendarObj = a.$calendar
                .fullCalendar({
                    slotDuration: "00:15:00",
                    minTime: "08:00:00",
                    maxTime: "23:00:00",
                    defaultView: "month",
                    handleWindowResize: !0,
                    height: o(window).height() - 200,
                    header: { left: "prev,next today", center: "title", right: "month,agendaWeek,agendaDay" },
                    events: `/all/room/${room_id}/reservations`,
                    editable: !0,
                    droppable: !0,
                    eventLimit: !0,
                    selectable: !0,
                    drop: function (e) {
                        a.onDrop(o(this), e)
                    },
                    select: function (e, t, n) {
                        console.log(n);
                        a.onSelect(e, t, n)
                    },
                    eventClick: function (e, t, n) {
                        a.onEventClick(e, t, n)
                    },
                }), this.$saveCategoryBtn.on("click", function () {
                    var e = a.$categoryForm.find("input[name='category-name']").val(),
                        t = a.$categoryForm.find("select[name='category-color']").val();
                    null !== e && 0 != e.length && (a.$extEvents.append('<div class="external-event bg-' + t + '" data-class="bg-' + t + '" style="position: relative;"><i class="mdi mdi-checkbox-blank-circle mr-2 vertical-middle"></i>' + e + "</div>"), a.enableDrag())
                })
        },
        o.CalendarApp = new e, o.CalendarApp.Constructor = e
}
    (window.jQuery), function () { "use strict"; window.jQuery.CalendarApp.init() }();