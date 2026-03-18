# rm_samsapi – Technische Dokumentation

**Autor:** Rene Schoenfeld (r.schoenfeld@resch-media.de)  
**Firma:** resch media, Huckarderstrasse 10-12, 44147 Dortmund  
**Version:** 1.0.0  
**TYPO3-Kompatibilität:** 10.4.26-10.99.99  
**PHP-Mindestversion:** 7.2  

---

## Inhaltsverzeichnis

1. [Übersicht](#1-übersicht)
2. [Voraussetzungen & Abhängigkeiten](#2-voraussetzungen--abhängigkeiten)
3. [Installation](#3-installation)
4. [API-Klassen](#4-api-klassen)
5. [Repository](#5-repository)

---

## 1. Übersicht

`rm_samsapi` enthält Klassen und Tools für die SAMS API. Die Extension dient als Backend für die Kommunikation mit einem externen SAMS-System.

**Kernfunktionen:**

- SAMS API-Anbindung
- Repository für Datenabruf
- TYPO3-System-Template-Integration

---

## 2. Voraussetzungen & Abhängigkeiten

| Paket | Version |
|---|---|
| `typo3/cms-core` | 10.4.26-10.99.99 |
| PHP | >= 7.2 |

---

## 3. Installation

1. Extension in das Verzeichnis `typo3conf/ext/rm_samsapi` legen
2. Im Extension Manager aktivieren
3. System-Template einbinden

---

## 4. API-Klassen

### SamsApi

**Klasse:** `Reschmedia\RmSamsapi\Api\SamsApi`

Hauptklasse für die Kommunikation mit der SAMS API. Stellt Methoden für den Datenaustausch mit dem externen System bereit.

---

## 5. Repository

### SamsRepository

**Klasse:** `Reschmedia\RmSamsapi\Domain\Repository\SamsRepository`

Repository für den Abruf von SAMS-Daten aus der Datenbank.
