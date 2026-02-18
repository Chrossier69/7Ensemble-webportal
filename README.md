# 7 Ensemble - Plateforme d'Entraide Communautaire

## 📋 Vue d'ensemble

**7 Ensemble** est une plateforme web française dédiée à l'entraide financière communautaire. Le projet repose sur un concept innovant de réseaux solidaires utilisant les nombres symboliques 7 et 21 pour créer des "constellations" d'entraide mutuelle.

### Concept Principal
- **21€** de contribution initiale
- Deux constellations disponibles :
  - **Triangulum** : 3 personnes (gain potentiel : 7'789€)
  - **Pléiades** : 7 personnes (gain potentiel : 1'575'747€)
- Système en **7 tours progressifs** où chaque membre contribue et avance ensemble

### Localisation
- **Éditeur** : Christophe Rossier
- **Localisation** : 1926 Fully (VS), Suisse
- **Langue** : Français
- **Conformité** : RGPD + Loi Suisse sur la Protection des Données (LPD)

---

## 🌐 Pages du Site

### Pages Principales

#### 1. **index.html** - Page d'accueil (607 lignes)
Contenu :
- Hero section avec vidéo background
- Présentation du principe "Force du 7 et du 21"
- Visualisation des deux constellations (Triangulum & Pléiades)
- Tableau comparatif des 7 tours
- Témoignages et section "Coup de Gueule"
- Calculateur interactif de gains
- Réponses aux objections communes
- CTA pour rejoindre la révolution

#### 2. **les7tours.html** - Fonctionnement détaillé (432 lignes)
Contenu :
- Explication du principe de base
- Détails des 7 tours progressifs pour les deux systèmes
- Tableaux de progression par tour
- Calculs et montants à chaque étape
- Comparaison Triangulum vs Pléiades

#### 3. **mission.html** - Mission et valeurs (802 lignes)
Contenu :
- Déclaration de mission
- Valeurs fondamentales
- Philosophie de l'entraide
- Vision à long terme
- Storytelling et contexte
- Appel à l'action

### Pages Légales

#### 4. **mentions-legales.html** - Mentions légales (231 lignes)
- Informations sur l'éditeur
- Contact et localisation
- Hébergement
- Propriété intellectuelle
- Responsabilité

#### 5. **politique-confidentialite.html** - Politique de confidentialité (339 lignes)
- Conformité RGPD et LPD Suisse
- 10 sections détaillées :
  1. Introduction
  2. Responsable du traitement
  3. Données collectées
  4. Finalités du traitement
  5. Base légale
  6. Durée de conservation
  7. Partage des données
  8. Droits des utilisateurs
  9. Sécurité des données
  10. Contact DPO

#### 6. **conditions-generales.html** - Conditions générales (347 lignes)
- Acceptation des conditions
- Utilisation du service
- Inscription et compte utilisateur
- Obligations des utilisateurs
- Responsabilités
- Avertissements sur les risques
- Modification et résiliation

### Fichier Utilitaire

#### 7. **footer-snippet.html** - Template de footer (272 lignes)
- Composant réutilisable du footer
- 4 colonnes : Liens rapides, Documents, Contact, Informations
- Styles intégrés

---

## 🎨 Structure des Fichiers

```
7ensemble-webportal/
│
├── index.html                          # Page d'accueil
├── les7tours.html                      # Fonctionnement des 7 tours
├── mission.html                        # Mission et valeurs
├── mentions-legales.html               # Mentions légales
├── politique-confidentialite.html      # Politique RGPD
├── conditions-generales.html           # CGU
├── footer-snippet.html                 # Template footer
│
├── css/
│   ├── styles.css                      # Styles principaux (4175 lignes)
│   ├── home.css                        # Styles spécifiques page d'accueil
│   ├── main.css                        # Styles communs
│   ├── mission.css                     # Styles page mission
│   └── tours.css                       # Styles page tours
│
├── js/
│   ├── main.js                         # Logique commune (5.8KB)
│   ├── modal.js                        # Gestion des modals d'inscription (11KB)
│   ├── animations.js                   # Animations et effets visuels (5KB)
│   └── community-canvas.js             # Canvas interactif communautaire (2.8KB)
│
├── img/
│   ├── banner-video.mp4                # Vidéo banner (374KB)
│   ├── banner-img.png                  # Image fallback banner (857KB)
│   ├── banner.png                      # Image banner alternative (142KB)
│   ├── Animated_Banner.gif             # GIF animé (1.9MB)
│   ├── Screenshot.png                  # Capture d'écran (287KB)
│   └── 1.jpeg - 7.jpeg                 # Images numérotées (tours)
│
└── images/                             # Répertoire images additionnel
```

---

## ⚙️ Technologies Utilisées

### Frontend
- **HTML5** : Structure sémantique moderne
- **CSS3** :
  - Flexbox & CSS Grid
  - Animations et transitions
  - Gradients et effets visuels
  - Media queries (responsive design)
  - Custom properties (variables CSS)
- **JavaScript (Vanilla)** :
  - ES6+ features
  - DOM manipulation
  - Event handling
  - Form validation
  - Modal management
  - Scroll animations

### Ressources Médias
- **Vidéo HTML5** : Backgrounds animés avec autoplay/loop
- **Images optimisées** : PNG, JPEG, GIF
- **Fallback images** : Support navigateurs sans vidéo

### Optimisations
- **Preload** : Chargement prioritaire des ressources critiques
- **Lazy loading** : Chargement différé des médias
- **Responsive images** : Adaptation selon viewport
- **Smooth scrolling** : Navigation fluide
- **Performance** : Throttle et debounce pour événements

---

## 🎯 Fonctionnalités Clés

### 1. **Système de Constellations Interactif**
- Visualisation animée des réseaux Triangulum et Pléiades
- Animations CSS pour simuler les connexions
- Canvas interactif pour représentation graphique

### 2. **Calculateur de Gains**
- Calcul dynamique des gains potentiels
- Comparaison entre les deux systèmes
- Affichage des 7 tours progressifs

### 3. **Modal d'Inscription Intelligent**
Trois modes de fonctionnement :
- **Mode "Both"** : Affiche les deux options (3 et 7 personnes)
- **Mode "3 Only"** : Affiche uniquement l'option Triangulum
- **Mode "7 Only"** : Affiche uniquement l'option Pléiades

Fonctions JavaScript :
```javascript
showModalBothOptions()    // Boutons génériques "Rejoindre"
showModalThreeOnly()      // Bouton "Commencer avec 3"
showModalSevenOnly()      // Bouton "Commencer avec 7"
```

### 4. **Video Background Hero**
- Vidéo en autoplay/loop pour effet immersif
- Overlay pour lisibilité du texte
- Image poster pour chargement initial
- Fallback image si vidéo non supportée

### 5. **Animations au Scroll**
- Révélation progressive du contenu
- Animation des chiffres (compteurs)
- Effets de parallaxe
- Throttling pour performance

### 6. **Navigation Responsive**
- Menu mobile toggle
- Smooth scroll vers sections
- Navigation sticky
- Hamburger menu pour mobile

### 7. **Footer 4 Colonnes**
Structure :
- **Liens Rapides** : Navigation site
- **Documents** : Liens légaux simples (Mentions, Confidentialité, CGU)
- **Contact** : Email, téléphone, adresse
- **Informations** : Horaires, réseaux sociaux

Responsive :
- Desktop : 4 colonnes
- Tablet (≤992px) : 2 colonnes
- Mobile (≤768px) : 1 colonne

---

## 🎨 Système de Design

### Palette de Couleurs

#### Couleurs Principales
- **Primary Cyan** : `#4ecdc4` - Accent principal
- **Purple** : `#667eea` - Accent secondaire
- **Pink** : `#f093fb` - Highlights et CTA
- **Red** : `#ff6b6b` - Avertissements

#### Couleurs de Fond
- **Dark Background** : `rgba(15,20,25,0.95)` - Fond principal
- **Blue Gradient** : `rgba(26,35,126,0.8)` → `rgba(57,73,171,0.7)`

#### Texte
- **White Primary** : `rgba(255,255,255,0.9)`
- **White Secondary** : `rgba(255,255,255,0.8)`
- **White Muted** : `rgba(255,255,255,0.6)`

### Typographie
- **Titres H1** : 3rem - 3.5rem, font-weight: 900
- **Titres H2** : 2.5rem, font-weight: 800
- **Titres H3** : 2rem, font-weight: 700
- **Body** : 1rem, line-height: 1.6
- **Gradients de texte** : Effets dégradés sur titres principaux

### Composants Stylisés

#### Boutons
```css
.btn-primary          /* Bouton principal cyan */
.btn-gradient-pink    /* Bouton dégradé rose */
.btn-xl-cta           /* Bouton XL pour CTA */
```

#### Cartes et Sections
```css
.explanation-box      /* Boîtes d'explication */
.legal-section        /* Sections pages légales */
.constellation-container  /* Conteneurs constellations */
```

#### Effets Visuels
- **Border-left accents** : 4px solid #4ecdc4
- **Hover effects** : Transform, box-shadow, color transition
- **Background transparency** : rgba() pour effets de verre
- **Border-radius** : 5px - 10px pour arrondi doux

---

## 📱 Responsive Design

### Breakpoints
```css
/* Mobile first approach */
@media (max-width: 768px)   /* Mobile */
@media (max-width: 992px)   /* Tablet */
@media (min-width: 769px)   /* Desktop */
@media (min-width: 1200px)  /* Large Desktop */
```

### Adaptations
- **Navigation** : Menu hamburger sur mobile
- **Grid Layouts** : Passage de 4 colonnes à 2 puis 1
- **Typography** : Réduction des tailles de police
- **Spacing** : Ajustement des marges et paddings
- **Videos** : Preload conditionnel (min-width: 769px)
- **Images** : Fallback et optimisation selon device

---

## 🚀 Installation et Déploiement

### Prérequis
Aucun prérequis spécifique - Site statique HTML/CSS/JS

### Installation Locale

1. **Cloner le projet**
```bash
git clone <repository-url>
cd 7ensemble-webportal
```

2. **Lancer un serveur local**

Option 1 - Python :
```bash
python -m http.server 8000
```

Option 2 - Node.js :
```bash
npx http-server
```

Option 3 - PHP :
```bash
php -S localhost:8000
```

3. **Accéder au site**
```
http://localhost:8000
```

### Déploiement Production

#### Hébergement Statique
Compatible avec :
- **GitHub Pages**
- **Netlify**
- **Vercel**
- **AWS S3 + CloudFront**
- **Firebase Hosting**
- N'importe quel serveur web (Apache, Nginx)

#### Fichiers à uploader
Tous les fichiers du répertoire racine :
- *.html
- css/
- js/
- img/

#### Configuration Serveur

**Apache (.htaccess)**
```apache
# Force HTTPS
RewriteEngine On
RewriteCond %{HTTPS} off
RewriteRule ^(.*)$ https://%{HTTP_HOST}%{REQUEST_URI} [L,R=301]

# Cache static resources
<filesMatch ".(css|jpg|jpeg|png|gif|js|ico|mp4)$">
Header set Cache-Control "max-age=2592000, public"
</filesMatch>
```

**Nginx**
```nginx
location / {
    try_files $uri $uri/ /index.html;
}

location ~* \.(css|js|jpg|jpeg|png|gif|ico|mp4)$ {
    expires 30d;
    add_header Cache-Control "public, immutable";
}
```

---

## 🔧 Maintenance et Personnalisation

### Modifier le Contenu

#### Changer les montants
**Fichier** : `index.html`
```html
<!-- Ligne 60 -->
<div class="transformation-amount">1'575'747€</div>
```

#### Ajouter un témoignage
**Fichier** : `index.html`
```html
<!-- Section témoignages -->
<div class="testimonial-card">
    <p>"Votre témoignage ici..."</p>
    <span class="testimonial-author">- Nom de la personne</span>
</div>
```

#### Modifier les informations légales
**Fichiers** :
- `mentions-legales.html` - Éditeur, contact, hébergement
- `politique-confidentialite.html` - RGPD, collecte de données
- `conditions-generales.html` - Conditions d'utilisation

### Modifier les Styles

#### Couleurs principales
**Fichier** : `css/styles.css`
```css
/* Chercher et remplacer */
#4ecdc4  /* Cyan principal */
#667eea  /* Purple */
#f093fb  /* Pink */
```

#### Footer layout
**Fichier** : `css/styles.css` (ligne 3841)
```css
.footer-main {
    grid-template-columns: repeat(4, 1fr);  /* Nombre de colonnes */
}
```

#### Document links styling
**Fichier** : `css/styles.css` (ligne 3947)
```css
.doc-link {
    color: rgba(255,255,255,0.8);  /* Simple text links */
    text-decoration: none;
}
```

### Ajouter une Nouvelle Page

1. **Créer le fichier HTML**
```bash
cp index.html nouvelle-page.html
```

2. **Modifier le contenu**
```html
<title>Nouveau Titre - 7 Ensemble</title>
```

3. **Ajouter au menu**
Dans tous les fichiers HTML :
```html
<div class="nav-menu">
    <a href="index.html">Accueil</a>
    <a href="les7tours.html">Les 7 Tours</a>
    <a href="mission.html">Mission</a>
    <a href="nouvelle-page.html">Nouveau Lien</a>
</div>
```

4. **Ajouter au footer**
```html
<div class="footer-section">
    <h3>Liens rapides</h3>
    <a href="nouvelle-page.html">Nouveau Lien</a>
</div>
```

---

## 📊 Métriques du Projet

### Code Statistics
- **Total HTML** : 3,030 lignes (7 fichiers)
- **Total CSS** : ~4,175 lignes (styles.css principal)
- **Total JavaScript** : ~24KB (4 fichiers)
- **Total Médias** : ~3.6MB

### Pages par Taille
1. mission.html - 802 lignes
2. index.html - 607 lignes
3. les7tours.html - 432 lignes
4. conditions-generales.html - 347 lignes
5. politique-confidentialite.html - 339 lignes
6. footer-snippet.html - 272 lignes
7. mentions-legales.html - 231 lignes

### Fichiers JavaScript
- modal.js - 11KB (gestion modals)
- main.js - 5.8KB (logique commune)
- animations.js - 5KB (effets visuels)
- community-canvas.js - 2.8KB (canvas interactif)

---

## 🌐 Compatibilité Navigateurs

### Desktop
- ✅ Chrome 90+ (recommandé)
- ✅ Firefox 88+
- ✅ Safari 14+
- ✅ Edge 90+

### Mobile
- ✅ Chrome Mobile
- ✅ Safari iOS 14+
- ✅ Firefox Mobile
- ✅ Samsung Internet

### Features Support
- **CSS Grid** : IE11 avec préfixes
- **Flexbox** : Tous navigateurs modernes
- **HTML5 Video** : Tous navigateurs modernes (fallback image inclus)
- **ES6 JavaScript** : Transpilation recommandée pour IE11

---

## 🔐 Sécurité et Conformité

### RGPD
- Politique de confidentialité complète
- Information sur collecte de données
- Droits des utilisateurs (accès, rectification, suppression)
- Base légale du traitement
- Contact DPO disponible

### Loi Suisse (LPD)
- Conformité avec législation suisse
- Responsable du traitement identifié
- Transparence sur utilisation des données

### Bonnes Pratiques
- Liens externes avec `rel="noopener noreferrer"` (sauf liens internes)
- Formulaires avec validation côté client
- Headers de sécurité recommandés
- HTTPS fortement recommandé

---

## 🐛 Corrections Récentes

### Dernières Mises à Jour
1. **Footer 4 colonnes** - Expansion du footer de 3 à 4 colonnes avec responsive
2. **Simplification des liens documents** - Suppression des icônes et styling fancy
3. **Pages légales HTML** - Création de 3 pages légales professionnelles
4. **Remplacement emoji** - Changement de 🫶 vers ❤️ pour compatibilité
5. **Text-shadow** - Retrait de l'effet sur .transformation-amount
6. **Video banner** - Ajout du banner vidéo sur toutes les pages

---

## 📞 Contact et Support

### Éditeur
**7ensemble.ch**
- **Responsable** : Christophe Rossier
- **Adresse** : 1926 Fully (VS), Suisse
- **Email** : contact@7ensemble.ch

### Support Technique
Pour toute question technique concernant le site :
- Consulter les fichiers dans `/mentions-legales.html`
- Email de contact dans le footer du site

---

## 📝 Licence et Copyright

© 2025 7ensemble.ch - Tous droits réservés

### Propriété Intellectuelle
- **Design** : 7 Ensemble
- **Contenu** : 7 Ensemble
- **Code** : 7 Ensemble
- **Médias** : Propriété de 7 Ensemble (sauf mention contraire)

### Utilisation
L'ensemble du contenu est protégé par le droit d'auteur suisse et international. Toute reproduction, distribution ou modification nécessite l'autorisation écrite préalable de l'éditeur.

---

## 🗺️ Roadmap Future (Suggestions)

### Fonctionnalités Potentielles
- [ ] Système de login/authentification
- [ ] Dashboard membre personnalisé
- [ ] Suivi des constellations en temps réel
- [ ] Intégration paiement (Stripe, PayPal)
- [ ] Système de parrainage automatisé
- [ ] Notifications par email/SMS
- [ ] Application mobile (PWA)
- [ ] Multi-langue (EN, DE, IT)
- [ ] Blog/Actualités
- [ ] FAQ interactive

### Optimisations Techniques
- [ ] Minification CSS/JS pour production
- [ ] Optimisation images (WebP, lazy loading)
- [ ] Service Worker pour mode offline
- [ ] Analytics (Google Analytics, Matomo)
- [ ] A/B Testing sur CTA
- [ ] SEO avancé (Schema.org, Open Graph)

---

## 🤝 Contribution

Pour contribuer au projet :
1. Fork le repository
2. Créer une branche feature (`git checkout -b feature/amelioration`)
3. Commit les changements (`git commit -m 'Ajout fonctionnalité'`)
4. Push vers la branche (`git push origin feature/amelioration`)
5. Créer une Pull Request

---

**Version** : 1.0.0
**Dernière mise à jour** : Janvier 2026
**Statut** : Production active

---

*Réalisé avec ❤️ pour la communauté 7 Ensemble*
