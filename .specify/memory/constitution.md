<!--
SYNC IMPACT REPORT
==================
Version Change: Initial → 1.0.0
Rationale: First constitution establishment with comprehensive principles

Modified Principles:
- NEW: Code Quality Standards (Principle I)
- NEW: SOLID Principles (Principle II)
- NEW: Testing Standards (Principle III)
- NEW: User Experience Consistency (Principle IV)
- NEW: Performance Requirements (Principle V)

Added Sections:
- Development Workflow (Section 2)
- Quality Gates (Section 3)
- Governance

Removed Sections: None (initial version)

Templates Requiring Updates:
- ✅ .specify/templates/plan-template.md - Constitution Check section ready
- ✅ .specify/templates/spec-template.md - Requirements align with principles
- ✅ .specify/templates/tasks-template.md - Task categorization supports all principles

Follow-up TODOs: None
-->

# TMS Multi-User Docker Constitution

## Core Principles

### I. Code Quality Standards

All code contributions MUST adhere to the following non-negotiable quality standards:

- **Readability First**: Code MUST be self-documenting with clear variable names, function names, and logical structure. Comments are required only where business logic is non-obvious.
- **Consistent Style**: Code MUST follow language-specific style guides (PSR-12 for PHP, Airbnb for JavaScript, PEP 8 for Python). Linting tools MUST pass before commit.
- **No Dead Code**: Unused imports, commented code blocks, and unreachable code MUST be removed. If code may be needed later, rely on version control.
- **DRY Principle**: Code duplication beyond 3 lines in 2+ locations MUST be refactored into shared functions or classes.
- **Security by Default**: All inputs MUST be validated and sanitized. SQL injection, XSS, CSRF, and OWASP Top 10 vulnerabilities MUST be prevented through secure coding practices.

**Rationale**: High code quality reduces bugs, improves maintainability, accelerates onboarding, and prevents security breaches that could compromise the TMS platform.

### II. SOLID Principles

All object-oriented code MUST follow SOLID design principles:

- **Single Responsibility Principle**: Each class MUST have one reason to change. Classes exceeding 300 lines or handling multiple concerns MUST be refactored.
- **Open/Closed Principle**: Code MUST be open for extension but closed for modification. Use interfaces, abstract classes, and dependency injection to enable extensibility.
- **Liskov Substitution Principle**: Derived classes MUST be substitutable for their base classes without altering program correctness.
- **Interface Segregation Principle**: Interfaces MUST be client-specific. No client should depend on methods it does not use.
- **Dependency Inversion Principle**: High-level modules MUST NOT depend on low-level modules. Both MUST depend on abstractions. Use dependency injection containers.

**Rationale**: SOLID principles create maintainable, testable, and scalable architectures. They reduce coupling, improve testability, and enable safe refactoring as the TMS platform evolves.

### III. Testing Standards (NON-NEGOTIABLE)

All features MUST include appropriate automated tests before being considered complete:

- **Test-Driven Development**: For critical business logic, tests MUST be written first, verified to fail, then implementation proceeds (Red-Green-Refactor).
- **Test Coverage Requirements**: New code MUST maintain minimum 80% line coverage. Critical paths (authentication, payments, data integrity) MUST have 100% coverage.
- **Test Types Required**:
  - **Unit Tests**: All business logic functions, services, and models MUST have unit tests
  - **Integration Tests**: API endpoints, database interactions, and service integrations MUST have integration tests
  - **Contract Tests**: Public APIs and inter-service communication MUST have contract tests
- **Test Quality**: Tests MUST be independent, repeatable, and fast (<5 seconds for unit tests). No tests should depend on external services in CI/CD.
- **Test Naming**: Test names MUST clearly describe the scenario: `test_<method>_<scenario>_<expected_result>` (e.g., `test_createUser_withInvalidEmail_throwsValidationError`)

**Rationale**: Comprehensive testing catches bugs early, enables confident refactoring, serves as living documentation, and reduces production incidents that impact TMS users.

### IV. User Experience Consistency

All user-facing features MUST maintain consistent and predictable interactions:

- **Design System Compliance**: All UI components MUST use approved design tokens (colors, spacing, typography, icons) from the design system. Custom styles require architecture review.
- **Accessibility Standards**: All interfaces MUST meet WCAG 2.1 AA standards. Forms MUST have proper labels, keyboard navigation MUST work, and screen readers MUST announce content correctly.
- **Error Handling UX**: All errors MUST provide clear, actionable messages. Technical errors MUST be logged but show user-friendly messages. Validation errors MUST highlight specific fields.
- **Loading States**: All async operations >500ms MUST show loading indicators. Users MUST never see frozen or unresponsive interfaces.
- **Responsive Design**: All interfaces MUST work on mobile (320px), tablet (768px), and desktop (1024px+) viewports without horizontal scrolling.
- **Progressive Enhancement**: Core functionality MUST work with JavaScript disabled. Enhanced features may require JavaScript but MUST degrade gracefully.

**Rationale**: Consistent UX builds user trust, reduces support burden, improves accessibility for all users, and strengthens the TMS brand across the multi-user platform.

### V. Performance Requirements

All features MUST meet performance standards to ensure platform scalability:

- **Response Time Targets**:
  - API endpoints: <200ms p95 for CRUD operations, <500ms p95 for complex queries
  - Page load: <2 seconds for initial load, <1 second for navigation
  - Database queries: <50ms p95 for indexed lookups, <200ms p95 for reports
- **Resource Limits**:
  - API memory: <256MB per request
  - Database connections: Pooled with max 100 connections across all services
  - Frontend bundle: <500KB gzipped for initial load
- **Scalability Requirements**:
  - Horizontal scaling: Services MUST be stateless and support multiple instances
  - Caching: Expensive operations MUST be cached (Redis, HTTP cache headers)
  - N+1 queries: MUST be eliminated using eager loading or query optimization
- **Monitoring**: All performance-critical operations MUST emit metrics (response time, throughput, error rate) to monitoring systems.

**Rationale**: Performance directly impacts user satisfaction, operational costs, and system capacity. Poor performance leads to user abandonment and increased infrastructure costs.

## Development Workflow

All development work MUST follow this workflow:

1. **Feature Planning**: Features MUST start with a specification in `/specs/<feature>/spec.md` following the spec template
2. **Architecture Design**: Non-trivial features MUST have an implementation plan in `/specs/<feature>/plan.md` with architecture decisions documented
3. **Branch Strategy**: All work MUST happen on feature branches named `<issue-number>-<feature-name>` branched from `master`
4. **Code Review**: All changes MUST be reviewed by at least one other developer before merge. Reviews MUST verify constitution compliance
5. **CI/CD Pipeline**: All commits MUST pass automated checks (linting, tests, security scans) before merge
6. **Documentation**: Public APIs, complex algorithms, and architectural decisions MUST be documented in code or markdown files

## Quality Gates

Before code can be merged to `master`, it MUST pass all of the following gates:

1. **Constitution Check**: Code review MUST verify compliance with all core principles. Violations MUST be justified in the PR description
2. **Automated Tests**: All tests MUST pass. Coverage MUST meet minimum thresholds (80% overall, 100% for critical paths)
3. **Performance Tests**: Performance-sensitive changes MUST include benchmark results demonstrating compliance with performance requirements
4. **Security Scan**: No HIGH or CRITICAL security vulnerabilities from static analysis tools (e.g., Snyk, SonarQube)
5. **Linting**: All linting rules MUST pass with no warnings or errors
6. **Accessibility Audit**: UI changes MUST pass automated accessibility scans (e.g., axe, Lighthouse)
7. **Documentation**: Changes affecting public APIs or architecture MUST update relevant documentation

## Governance

This constitution supersedes all other development practices and conventions.

**Amendment Process**:
- Constitution changes MUST be proposed through the `/speckit.constitution` command
- Amendments MUST be reviewed by the technical lead and at least 2 senior engineers
- Breaking changes require a migration plan for existing code
- Version numbering follows semantic versioning:
  - MAJOR: Backward incompatible principle removals or fundamental redefinitions
  - MINOR: New principles added or material expansions to existing principles
  - PATCH: Clarifications, wording improvements, or non-semantic refinements

**Compliance Enforcement**:
- All pull requests MUST verify constitution compliance in the PR template checklist
- Code reviews MUST specifically check for principle violations
- Complexity MUST be justified when constitution rules are difficult to follow (use Complexity Tracking table in plan.md)
- Teams MUST conduct quarterly constitution review meetings to assess effectiveness and propose improvements

**Exceptions**:
- Emergency hotfixes MAY bypass non-critical quality gates (tests, documentation) but MUST create follow-up issues
- Prototype/spike branches MAY bypass all gates but MUST NOT merge to master
- Third-party integrations with immutable APIs MAY violate SOLID principles if properly documented with rationale

**Version**: 1.0.0 | **Ratified**: 2025-11-24 | **Last Amended**: 2025-11-24
