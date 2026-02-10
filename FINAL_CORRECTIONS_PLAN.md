# 7 ENSEMBLE - FINAL CORRECTIONS IMPLEMENTATION PLAN

## REFERENCE STANDARD: "Zero Risk" Block

```css
.risk-zero-section {
    background: radial-gradient(circle at center, #d9052c, #02f0fcd4);
    padding: 3rem 2rem;
    border-radius: 2rem;
    margin: 3rem auto;
    max-width: 1400px;
    position: relative;
    overflow: hidden;
    box-shadow: inset 0 0 7px rgba(0, 0, 0, 0.6);
}
```

## STANDARD TO APPLY TO ALL BLOCKS:
- **max-width:** 1400px
- **margin:** 3rem auto (centers container)
- **padding:** 3rem 2rem (mobile), 4rem 3rem (tablet), 4rem 4rem (desktop)
- **border-radius:** 2rem
- **box-shadow:** inset 0 0 7px rgba(0, 0, 0, 0.6)
- **No full-width containers** except page background

---

## 1️⃣ INDEX PAGE FIXES

### A. Reduce Header Height (~50%)
**Current:** Banner video uses aspect ratio padding-bottom: 23.125%
**New:** Reduce to ~12% for shorter header

### B. Sections to Standardize:
1. `.principe-section` - "Why 21€ / Why 7"
2. `.explanation-box` - Various explanations
3. `.urgency-section` - "Every day of delay"
4. `.legal-section-box` - Legal info
5. `.cta-section-purple` - Final CTA
6. All constellation/tour sections

### C. Remove Nested Containers:
- Remove wrapper around "100% legal / zero risk / heart message"
- Each section should be independent with standard styling

### D. Footer:
- Add "White Paper" link
- Make identical across all pages
- Note: Rebuild White Paper natively (not Canva)

---

## 2️⃣ LES 7 TOURS PAGE FIXES

### A. Sections to Standardize:
1. Base principle explanation
2. Triangulum section
3. Pléiades section (fix alignment)
4. All comparison tables

### B. Alignment Fix:
- Triangulum is correct
- Apply same correction to Pléiades symmetrically
- Ensure both columns perfectly aligned

### C. Width Consistency:
- All information blocks must be 1400px max-width
- Centered with `margin: auto`

---

## 3️⃣ MISSION PAGE - COMPLETE REBUILD

### Requirements:
- Follow GitHub structure exactly
- Apply standard 1400px width to all containers
- **TEXT ONLY** - no videos/multimedia
- Reduce vertical spacing (currently too long)
- Use standard block styling throughout

### Structure:
1. Video banner header (existing)
2. Navigation (existing)
3. Mission statement block (standard styling)
4. Vision blocks (standard styling)
5. Goals section (standard styling)
6. CTA block (standard styling)
7. Footer (standard)

---

## 4️⃣ CSS CHANGES REQUIRED

### Create Universal Standard Block Class:
```css
.standard-block {
    max-width: 1400px;
    margin: 3rem auto;
    padding: 3rem 2rem;
    border-radius: 2rem;
    box-shadow: inset 0 0 7px rgba(0, 0, 0, 0.6);
    position: relative;
    overflow: hidden;
}

@media (min-width: 768px) {
    .standard-block {
        padding: 4rem 3rem;
    }
}

@media (min-width: 992px) {
    .standard-block {
        padding: 4rem 4rem;
    }
}
```

### Update Existing Classes:
- `.principe-section` → add standard-block properties
- `.explanation-box` → add standard-block properties
- `.urgency-section` → add standard-block properties
- `.legal-section-box` → already has most, needs border-radius: 2rem
- `.cta-section-purple` → already standardized

---

## 5️⃣ GLOBAL BACKGROUND

### Ensure Continuous Gradient:
```css
body {
    background: linear-gradient(180deg,
        #0f1419 0%,
        #1a237e 30%,
        #3949ab 60%,
        #5c6bc0 85%,
        #9c27b0 100%
    );
    background-attachment: fixed;
    min-height: 100vh;
}
```

---

## 6️⃣ FOOTER STANDARDIZATION

### Must Be Identical On All Pages:
- Same structure (4 columns)
- Same links
- Add "Livre Blanc" / "White Paper" link
- Same styling
- Same spacing

### Footer Links:
1. Quick Links: Home, 7 Tours, Mission, **White Paper**
2. Documents: Legal notices, Privacy, T&C
3. Contact: Email, Phone, Address
4. Info: Hours, Description

---

## 7️⃣ IMPLEMENTATION ORDER

1. ✅ Create standardized CSS
2. ✅ Update Index page (header, containers, footer)
3. ✅ Update Les 7 Tours page (alignment, styling)
4. ✅ Rebuild Mission page (text only, proper structure)
5. ✅ Test all pages for consistency
6. ✅ Verify responsive behavior
7. ✅ Final QA check

---

## 8️⃣ TESTING CHECKLIST

### Visual Consistency:
- [ ] All blocks have same width (1400px max)
- [ ] All blocks have same depth/shadow
- [ ] All blocks have same border radius (2rem)
- [ ] No full-width containers except background
- [ ] Header height reduced by ~50%
- [ ] Footer identical on all pages

### Index Page:
- [ ] Header shorter
- [ ] All sections standardized
- [ ] Nested containers removed
- [ ] Urgency block same width
- [ ] White Paper link in footer

### 7 Tours Page:
- [ ] Pleiades aligned symmetrically with Triangulum
- [ ] All blocks standardized
- [ ] Tables properly formatted

### Mission Page:
- [ ] Completely rebuilt
- [ ] Text only (no videos)
- [ ] Proper spacing (not too long)
- [ ] All blocks standardized

### Responsive:
- [ ] Mobile: proper padding and layout
- [ ] Tablet: intermediate sizing
- [ ] Desktop: full 1400px width

---

## 9️⃣ FILES TO MODIFY

1. `css/styles.css` - Main stylesheet (comprehensive updates)
2. `index.html` - Structure and container fixes
3. `les7tours.html` - Alignment and styling fixes
4. `mission.html` - Complete rebuild
5. All pages - Footer standardization

---

## 🔟 DELIVERABLES

1. Updated CSS with universal `.standard-block` class
2. Fixed Index page matching all requirements
3. Fixed 7 Tours page with proper alignment
4. Rebuilt Mission page (text only, proper structure)
5. Standardized footer across all pages
6. White Paper page structure (content TBD)
7. Complete testing documentation

---

## TIMELINE

**Target:** Complete this weekend
**Priority:** High - Final corrections for project completion

---

## NOTES

- White Paper: Rebuild natively (Canva was example only)
- Videos: Text only for now, multimedia later
- Interview thumbnail: Will be added when ready
- Footer: Must be strictly identical across all pages
- No style variations between pages

---

**Status:** Planning Complete - Ready for Implementation
**Date:** January 2026
**Phase:** Final Corrections

