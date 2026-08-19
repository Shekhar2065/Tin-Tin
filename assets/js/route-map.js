(function () {
  "use strict";

  function initializeRouteMaps() {
    document.querySelectorAll("[data-svg-download]").forEach(function (button) {
      button.addEventListener("click", function () {
        const root = button.closest(".trip-infographic");
        const svg = root && root.querySelector("svg");
        if (!svg) return;
        const clone = svg.cloneNode(true);
        clone.setAttribute("xmlns", "http://www.w3.org/2000/svg");
        const source = '<?xml version="1.0" encoding="UTF-8"?>\n' + new XMLSerializer().serializeToString(clone);
        const downloadUrl = URL.createObjectURL(new Blob([source], { type: "image/svg+xml" }));
        const link = document.createElement("a");
        link.href = downloadUrl;
        link.download = button.dataset.downloadName || "trek-infographic-map.svg";
        document.body.appendChild(link);
        link.click();
        link.remove();
        URL.revokeObjectURL(downloadUrl);
      });
    });

    document.querySelectorAll("[data-route-map]").forEach(function (root) {
      if (typeof window.L === "undefined") return;

      let points;
      try {
        points = JSON.parse(root.dataset.routePoints || "[]");
      } catch {
        return;
      }
      if (!Array.isArray(points) || points.length === 0) return;

      const canvas = root.querySelector(".trip-map-canvas");
      const dayList = root.querySelector(".trip-map-days");
      const summary = root.querySelector(".trip-map-summary");
      const summaryDay = summary.querySelector("span");
      const summaryTitle = summary.querySelector("strong");
      const summaryText = summary.querySelector("p");
      const elevationList = root.querySelector(".trip-map-elevation-list");
      const tabs = Array.from(root.querySelectorAll("[data-route-view]"));
      const panels = Array.from(root.querySelectorAll("[data-route-panel]"));

      const map = window.L.map(canvas, {
        scrollWheelZoom: false,
        zoomControl: true,
      });

      window.L.tileLayer("https://tile.openstreetmap.org/{z}/{x}/{y}.png", {
        maxZoom: 18,
        attribution: '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors',
      }).addTo(map);

      points = points.filter(function (point) {
        return Number.isFinite(Number(point.lat)) && Number.isFinite(Number(point.lng));
      });
      if (points.length === 0) return;

      const coordinates = points.map(function (point) {
        return [Number(point.lat), Number(point.lng)];
      });
      const routeSegments = [];
      let currentSegment = [];
      points.forEach(function (point, index) {
        if (index > 0 && point.connectFromPrevious === false) {
          if (currentSegment.length > 1) routeSegments.push(currentSegment);
          currentSegment = [];
        }
        currentSegment.push(coordinates[index]);
      });
      if (currentSegment.length > 1) routeSegments.push(currentSegment);

      routeSegments.forEach(function (segment) {
        window.L.polyline(segment, {
          color: "#237a57",
          weight: 4,
          opacity: 0.88,
          lineJoin: "round",
        }).addTo(map);
      });

      const markers = points.map(function (point) {
        return window.L.circleMarker([point.lat, point.lng], {
          radius: 5,
          color: "#ffffff",
          weight: 2,
          fillColor: "#2874dc",
          fillOpacity: 1,
        }).addTo(map).bindTooltip(`Day ${point.day}: ${point.name}`);
      });

      const focusCoordinates = points
        .filter(function (point) { return point.mapFocus !== false; })
        .map(function (point) { return [Number(point.lat), Number(point.lng)]; });
      const initialCoordinates = focusCoordinates.length ? focusCoordinates : coordinates;
      if (initialCoordinates.length === 1) {
        map.setView(initialCoordinates[0], 11);
      } else {
        map.fitBounds(window.L.latLngBounds(initialCoordinates), { padding: [40, 40], maxZoom: 12 });
      }

      const dayButtons = points.map(function (point, index) {
        const button = document.createElement("button");
        button.type = "button";
        button.textContent = `Day ${point.day}`;
        button.setAttribute("aria-label", `Show day ${point.day}: ${point.name}`);
        button.addEventListener("click", function () {
          selectDay(index, true);
        });
        dayList.appendChild(button);
        return button;
      });

      const minimum = Math.min.apply(null, points.map(function (point) { return point.meters; }));
      const maximum = Math.max.apply(null, points.map(function (point) { return point.meters; }));
      const range = Math.max(1, maximum - minimum);
      points.forEach(function (point) {
        const item = document.createElement("div");
        item.className = "trip-map-elevation-item";
        const barHeight = 38 + ((point.meters - minimum) / range) * 235;
        item.innerHTML = `<strong>${Number(point.meters).toLocaleString()} m</strong><i style="height:${barHeight}px"></i><span>Day ${point.day}<br>${escapeHtml(point.name)}</span>`;
        elevationList.appendChild(item);
      });

      function selectDay(index, moveMap) {
        const point = points[index];
        dayButtons.forEach(function (button, buttonIndex) {
          button.classList.toggle("active", buttonIndex === index);
          button.setAttribute("aria-current", buttonIndex === index ? "step" : "false");
        });
        markers.forEach(function (marker, markerIndex) {
          marker.setStyle({
            radius: markerIndex === index ? 8 : 5,
            fillColor: markerIndex === index ? "#237a57" : "#2874dc",
          });
        });
        summaryDay.textContent = `Day ${point.day}`;
        summaryTitle.textContent = `${point.name} · ${Number(point.meters).toLocaleString()} m`;
        summaryText.textContent = point.summary;
        if (moveMap) map.flyTo([point.lat, point.lng], Math.max(map.getZoom(), 10), { duration: 0.7 });
      }

      tabs.forEach(function (tab) {
        tab.addEventListener("click", function () {
          const view = tab.dataset.routeView;
          tabs.forEach(function (item) {
            const selected = item === tab;
            item.classList.toggle("active", selected);
            item.setAttribute("aria-selected", String(selected));
          });
          panels.forEach(function (panel) {
            panel.classList.toggle("hidden", panel.dataset.routePanel !== view);
          });
          if (view === "map") window.setTimeout(function () { map.invalidateSize(); }, 0);
        });
      });

      const initialDayIndex = Math.max(0, points.findIndex(function (point) {
        return point.mapFocus !== false;
      }));
      selectDay(initialDayIndex, false);
    });
  }

  function escapeHtml(value) {
    const element = document.createElement("span");
    element.textContent = String(value);
    return element.innerHTML;
  }

  if (document.readyState === "loading") {
    document.addEventListener("DOMContentLoaded", initializeRouteMaps, { once: true });
  } else {
    initializeRouteMaps();
  }
})();
